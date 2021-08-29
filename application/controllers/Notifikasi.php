<?php

/**
 * Pada notifikasi status 0 untuk belum dikirim dan 1 apabila sudah dikirimkan
 */

/**
 * defined('BASEPATH') or exit('No direct script access allowed');
 * Berfungsi untuk memproteksi agar script yang kita buat tidak dapat diakses secara langsung 
 * dan harus melalui www.namaweb.com/controller
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Notifikasi extends CI_Controller
{
    /**
     * Function __construct() merupakan fungsi yang di eksekusi pertama kali 
     * saat Notifikasi controller dipanggil
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('NotifikasiModel', 'notif');
        $this->load->model('AplikasiModel', 'apk');
        $this->load->model('PenggunaAppModel', 'pengguna');

        deleteTokenEXP();
        cekAccessUser();
    }

    /**
     * Function notifikasi digunakan untuk menuju tampilan notifikasi
     */
    public function index($namaAplikasi, $idAplikasi)
    {
        $session_data = $this->session->userdata('datauser');

        $data['title'] = "Notifikasi Milik $namaAplikasi";
        $data['id_aplikasi'] = $idAplikasi;
        $data['namaAplikasi'] = $namaAplikasi;
        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $data['notifikasi'] = $this->notif->getNotifikasi($idAplikasi);
        $data['pengguna'] = $this->pengguna->getPengguna($idAplikasi);
        $data['aplikasi'] = $this->apk->myAplikasi($session_data['id_user']);
        $data['penerima'] = $this->notif->getPenerima();

        $this->template->render('Notifikasi/index', $data);
    }

    /**
     * Function tambahNotifikasi digunakan untuk menyimpan data notifikasi
     */
    public function tambahNotifikasi($namaAplikasi, $id)
    {
        $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
        $this->form_validation->set_rules('isinotif', 'IsiNotif', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->index($namaAplikasi, $id);
        } else {
            if ($this->notif->storeNotifikasi($this->input->post(), $id)) {
                $this->session->set_flashdata('message', pesanSukses('Notifikasi berhasil ditambahkan!'));
            } else {
                $this->session->set_flashdata('message', pesanGagal('Notifikasi gagal ditambahkan!'));
            }
            redirect('Notifikasi/index/' . $namaAplikasi . '/' . $id);
        }
    }

    /**
     * Function editNotifikasi digunakan untuk mengubah data notifikasi yang sudah ada
     */
    public function editNotifikasi($namaAplikasi, $idAplikasi)
    {
        $this->form_validation->set_rules('judul', 'Title', 'required|trim');
        $this->form_validation->set_rules('isinotif', 'IsiNotif', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->index($namaAplikasi, $idAplikasi);
        } else {
            if ($this->notif->updateNotifikasi($this->input->post())) {
                $this->session->set_flashdata('message', pesanSukses('Notifikasi berhasil diupdate!'));
            } else {
                $this->session->set_flashdata('message', pesanGagal('Notifikasi gagal diupdate!'));
            }
            redirect('Notifikasi/index/' . $namaAplikasi . '/' . $idAplikasi);
        }
    }

    /**
     * Function deleteNotifikasi digunakan untuk menghapus data notifikasi yang sudah ada
     */
    public function deleteNotifikasi($namaAplikasi, $idAplikasi, $id)
    {
        if ($this->notif->prosesDeleteNotifikasi($id)) {
            $this->session->set_flashdata('message', pesanGagal('Notifikasi berhasil dihapus!'));
        } else {
            $this->session->set_flashdata('message', pesanGagal('Notifikasi gagal dihapus!'));
        }

        redirect('Notifikasi/index/' . $namaAplikasi . '/' . $idAplikasi);
    }

    /**
     * Function ini digunakan untuk mengirimkan notifikasi ke penerima
     */
    public function kirimNotifikasi($namaAplikasi, $idAplikasi, $idNotif)
    {
        $notif = $this->notif->getNotifikasibyid($idNotif);
        $data = [
            'judul' => $notif['judul'],
            'isi' => $notif['isi'],
            'namaAplikasi' => $namaAplikasi
        ];
        $pengguna = $this->notif->getPenerimabynotif($idNotif);
        foreach ($pengguna as $row) {
            $email = $row['email_pengguna'];
            $this->load->library('email');

            $config =
                [
                    'smtp_host' => 'smtp.gmail.com',
                    'smtp_port' => '587',
                    'smtp_user' => 'qsenweb@gmail.com',
                    '_smtp_auth' => TRUE,
                    'smtp_pass' => 'vey@1234',
                    'smtp_crypto' => 'tls',
                    'protocol' => 'smtp',
                    'mailtype' => 'html',
                    'send_multipart' => FALSE,
                    'charset' => 'utf-8',
                    'wordwrap' => TRUE
                ];
            $this->email->initialize($config);

            $this->email->set_newline("\r\n");
            $this->email->from('qsenweb@gmail.com', $data['namaAplikasi']);
            $this->email->to($email);
            $this->email->subject($data['judul']);

            $body = $this->load->view('Notifikasi/tampilanEmail', $data, TRUE);
            $this->email->message($body);

            if ($this->email->send()) {
                $this->notif->setStatusKirim($idNotif, $row['id_pengguna']);
            } else {
                continue;
            }
        }
        if ($this->notif->setStatusNotif($idNotif)) {
            $this->session->set_flashdata('message', pesanSukses('Notifikasi berhasil dikirim!'));
        } else {
            $this->session->set_flashdata('message', pesanGagal('Notifikasi gagal dikirim!'));
        }
        redirect('Notifikasi/index/' . $namaAplikasi . '/' . $idAplikasi);
    }
}
