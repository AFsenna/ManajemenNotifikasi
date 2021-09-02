<?php

/**
 * Pada aplikasi status 1 untuk aktif dan 0 untuk tidak aktif 
 */

/**
 * defined('BASEPATH') or exit('No direct script access allowed');
 * Berfungsi untuk memproteksi agar script yang kita buat tidak dapat diakses secara langsung 
 * dan harus melalui www.namaweb.com/controller
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Aplikasi extends CI_Controller
{
    /**
     * Function __construct() merupakan fungsi yang di eksekusi pertama kali 
     * saat Aplikasi Controller dipanggil
     */

    public function __construct()
    {
        parent::__construct();

        $this->load->model('AplikasiModel', 'apk');
        $this->load->model('PenggunaAppModel', 'pengguna');

        cekAccessUser();
    }

    /**
     * Function aplikasi digunakan untuk menuju tampilan aplikasi
     */
    public function index()
    {
        $session_data = $this->session->userdata('datauser');

        $data['title'] = 'Aplikasi';
        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $data['aplikasi'] = $this->apk->myAplikasi($session_data['id_user']);
        $data['allApp'] = $this->apk->getAplikasi($session_data['id_user']);

        $this->template->render('aplikasi/index', $data);
    }

    /**
     * Function storeAplikasi digunakan untuk menyimpan aplikasi baru milik user
     */
    public function addAplikasi()
    {
        $this->form_validation->set_rules(
            'aplikasi',
            'Application',
            'required|trim|is_unique[aplikasi.nama_aplikasi]',
            [
                'is_unique' => 'Aplikasi sudah terdaftar!'
            ]
        );

        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $aplikasi = $this->input->post('aplikasi');
            $session_data = $this->session->userdata('datauser');
            $id_user = $session_data['id_user'];
            $data = [
                'nama_aplikasi' => $aplikasi,
                'user_id' => $id_user,
                'status' => 1
            ];

            if ($this->apk->storeAplikasi($data)) {
                $this->session->set_flashdata('message', pesanSukses('Aplikasi telah ditambahkan!'));
            } else {
                $this->session->set_flashdata('message', pesanGagal('Gagal menambahkan aplikasi!'));
            }

            redirect('aplikasi');
        }
    }

    /**
     * Function aktifkan digunakan untuk mengaktifkan aplikasi
     */

    public function aktifkan($id)
    {
        if ($this->apk->prosesAktifkan($id)) {
            $this->session->set_flashdata('message', pesanSukses('Aplikasi berhasil di aktifkan!'));
        } else {
            $this->session->set_flashdata('message', pesanGagal('Aplikasi gagal di aktifkan!'));
        }

        redirect('aplikasi');
    }

    /**
     * Function nonAktifkan digunakan untuk mengaktifkan aplikasi
     */

    public function nonAktifkan($id)
    {
        if ($this->apk->prosesNonAktifkan($id)) {
            $this->session->set_flashdata('message', pesanSukses('Aplikasi berhasil di nonAktifkan!'));
        } else {
            $this->session->set_flashdata('message', pesanGagal('Aplikasi gagal di nonAktifkan!'));
        }

        redirect('aplikasi');
    }

    /**
     * Function editAplikasi digunakan untuk mengubah data aplikasi yang sudah ada
     */
    public function editAplikasi($id)
    {
        $aplikasi = $this->db->get_where('aplikasi', ['id_aplikasi' => $id])->row_array();

        if ($this->input->post('aplikasi') == $aplikasi['nama_aplikasi']) {
            $this->form_validation->set_rules('aplikasi', 'Application', 'required|trim');
        } else {
            $this->form_validation->set_rules(
                'aplikasi',
                'Application',
                'required|trim|is_unique[aplikasi.nama_aplikasi]',
                [
                    'is_unique' => 'Aplikasi sudah terdaftar!'
                ]
            );
        }

        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $aplikasi = $this->input->post('aplikasi');

            if ($this->apk->updateAplikasi($id, $aplikasi)) {
                $this->session->set_flashdata('message', pesanSukses('Aplikasi berhasil di update!'));
            } else {
                $this->session->set_flashdata('message', pesanGagal('Aplikasi gagal di update!'));
            }

            redirect('aplikasi');
        }
    }

    /**
     * Function deleteAplikasi digunakan menghapus aplikasi yang dipilih
     * dan dengan syarat belum ada pengguna yang terdaftar
     */

    public function deleteAplikasi($id)
    {
        $cek = $this->pengguna->cekPenggunaApp($id);

        if ($cek) {
            $this->session->set_flashdata('message', pesanGagal('Aplikasi tidak bisa dihapus!'));
            redirect('aplikasi');
        } else {
            if ($this->apk->prosesDeleteAplikasi($id)) {
                $this->session->set_flashdata('message', pesanSukses('Aplikasi berhasil di hapus!'));
            } else {
                $this->session->set_flashdata('message', pesanGagal('Aplikasi gagal di hapus!'));
            }

            redirect('aplikasi');
        }
    }
}
