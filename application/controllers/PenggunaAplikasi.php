<?php

/**
 * Pada pengunaAplikasi status 0 untuk hidden dan 1 apabila aktif
 */

/**
 * defined('BASEPATH') or exit('No direct script access allowed');
 * Berfungsi untuk memproteksi agar script yang kita buat tidak dapat diakses secara langsung 
 * dan harus melalui www.namaweb.com/controller
 */
defined('BASEPATH') or exit('No direct script access allowed');

class PenggunaAplikasi extends CI_Controller
{
    /**
     * Function __construct() merupakan fungsi yang di eksekusi pertama kali 
     * saat PenggunaAplikasi Controller dipanggil
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('PenggunaAppModel', 'pengguna');
        $this->load->model('AplikasiModel', 'apk');
        deleteTokenEXP();
        cekAccessUser();
    }

    /**
     * Function index digunakan untuk menuju tampilan pengguna
     */
    public function index($namaAplikasi, $idAplikasi)
    {
        $session_data = $this->session->userdata('datauser');

        $data['title'] = "Pengguna Aplikasi $namaAplikasi";
        $data['namaAplikasi'] = $namaAplikasi;
        $data['id_aplikasi'] = $idAplikasi;
        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $data['aplikasi'] = $this->apk->myAplikasi($session_data['id_user']);
        $data['pengguna'] = $this->pengguna->getPengguna($idAplikasi);

        $this->template->render('PenggunaAplikasi/index', $data);
    }

    /**
     * Function storePengguna digunakan untuk menyimpan data pengguna aplikasi
     */
    public function storePengguna($namaAplikasi, $idAplikasi)
    {
        $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() == false) {
            $this->index($namaAplikasi, $idAplikasi);
        } else {
            $nama = $this->input->post('nama');
            $phone = $this->input->post('phone');
            $email = $this->input->post('email');

            $data = [
                'nama_pengguna' => $nama,
                'notelp_pengguna' => $phone,
                'email_pengguna' => $email,
                'aplikasi_id' => $idAplikasi,
                'status_pengguna' => 1
            ];

            if ($this->pengguna->prosesStorePengguna($data)) {
                $this->session->set_flashdata('message', pesanSukses('Pengguna aplikasi berhasil ditambahkan!'));
            } else {
                $this->session->set_flashdata('message', pesanGagal('Pengguna aplikasi gagal ditambahkan!'));
            }

            redirect('PenggunaAplikasi/index/' . $namaAplikasi . '/' . $idAplikasi);
        }
    }

    /**
     * Function editPengguna digunakan untuk mengubah data pengguna aplikasi yang sudah ada
     */
    public function editPengguna($namaAplikasi, $idAplikasi, $idPengguna)
    {
        $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() == false) {
            $this->index($namaAplikasi, $idAplikasi);
        } else {
            $nama = $this->input->post('nama');
            $phone = $this->input->post('phone');
            $email = $this->input->post('email');
            $set = [
                'nama_pengguna' => $nama,
                'notelp_pengguna' => $phone,
                'email_pengguna' => $email,
            ];

            if ($this->pengguna->updatePengguna($idPengguna, $set)) {
                $this->session->set_flashdata('message', pesanSukses('Pengguna aplikasi berhasil diupdate!'));
            } else {
                $this->session->set_flashdata('message', pesanSukses('Pengguna aplikasi gagal diupdate!'));
            }
            redirect('PenggunaAplikasi/index/' . $namaAplikasi . '/' . $idAplikasi);
        }
    }

    /**
     * Function deletePengguna digunakan menghapus aplikasi yang dipilih
     * dan dengan syarat belum ada pengguna yang terdaftar
     */

    public function deletePengguna($namaAplikasi, $idAplikasi, $id)
    {
        $cek = $this->pengguna->cekNotifPengguna($id);

        if ($cek) {
            $this->pengguna->prosesHidden($id);
            $this->session->set_flashdata('message', pesanSukses('Data pengguna aplikasi berhasil dihapus!'));
        } else {
            if ($this->pengguna->prosesDeletePengguna($id)) {
                $this->session->set_flashdata('message', pesanSukses('Data pengguna aplikasi berhasil dihapus!'));
            } else {
                $this->session->set_flashdata('message', pesanSukses('Data pengguna aplikasi gagal dihapus!'));
            }
        }

        redirect('PenggunaAplikasi/index/' . $namaAplikasi . '/' . $idAplikasi);
    }
}
