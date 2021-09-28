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
        $this->load->model('MediaModel', 'media');

        cekAccessUser();
    }

    /**
     * Function notifikasi digunakan untuk menuju tampilan notifikasi
     */
    public function index($idAplikasi)
    {
        $namaAplikasi = $this->apk->getByID($idAplikasi);
        $session_data = $this->session->userdata('datauser');

        $data['title'] = "Notifikasi Milik " . $namaAplikasi['nama_aplikasi'];
        $data['id_aplikasi'] = $idAplikasi;
        $data['namaAplikasi'] = $namaAplikasi['nama_aplikasi'];
        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $data['notifikasi'] = $this->notif->getNotifikasi($idAplikasi);
        $data['pengguna'] = $this->pengguna->getPengguna($idAplikasi);
        $data['aplikasi'] = $this->apk->myAplikasi($session_data['id_user']);
        $data['penerima'] = $this->notif->getPenerima();
        $data['media'] = $this->media->getMedia();

        $this->template->render('notifikasi/index', $data);
    }

    /**
     * Function tambahNotifikasi digunakan untuk menyimpan data notifikasi
     */
    public function tambahNotifikasi($id)
    {
        $this->form_validation->set_rules('judul', 'Judul', 'required|trim');
        $this->form_validation->set_rules('media_id', 'Media', 'required|trim');
        $this->form_validation->set_rules('isinotif', 'IsiNotif', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->index($id);
        } else {
            if ($this->notif->storeNotifikasi($this->input->post(), $id)) {
                $this->session->set_flashdata('message', pesanSukses('Notifikasi berhasil ditambahkan!'));
            } else {
                $this->session->set_flashdata('message', pesanGagal('Notifikasi gagal ditambahkan!'));
            }
            redirect('notifikasi/index/' . $id);
        }
    }

    /**
     * Function editNotifikasi digunakan untuk mengubah data notifikasi yang sudah ada
     */
    public function editNotifikasi($idAplikasi)
    {
        $this->form_validation->set_rules('judul', 'Title', 'required|trim');
        $this->form_validation->set_rules('media_id', 'Media', 'required|trim');
        $this->form_validation->set_rules('isinotif', 'IsiNotif', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->index($idAplikasi);
        } else {
            if ($this->notif->updateNotifikasi($this->input->post())) {
                $this->session->set_flashdata('message', pesanSukses('Notifikasi berhasil diupdate!'));
            } else {
                $this->session->set_flashdata('message', pesanGagal('Notifikasi gagal diupdate!'));
            }
            redirect('notifikasi/index/'  . $idAplikasi);
        }
    }

    /**
     * Function deleteNotifikasi digunakan untuk menghapus data notifikasi yang sudah ada
     */
    public function deleteNotifikasi($idAplikasi, $id)
    {
        if ($this->notif->prosesDeleteNotifikasi($id)) {
            $this->session->set_flashdata('message', pesanGagal('Notifikasi berhasil dihapus!'));
        } else {
            $this->session->set_flashdata('message', pesanGagal('Notifikasi gagal dihapus!'));
        }

        redirect('notifikasi/index/' . $idAplikasi);
    }

    /**
     * Function ini digunakan untuk mengirimkan notifikasi ke penerima
     */
    public function kirimNotifikasi($idAplikasi, $idNotif)
    {
        $namaAplikasi = $this->apk->getByID($idAplikasi);
        $notif = $this->notif->getNotifikasibyid($idNotif);
        $pengguna = $this->notif->getPenerimabynotif($idNotif);
        if ($notif['media_id'] == 1) {
            $data = [
                'judul' => $notif['judul'],
                'isi' => $notif['isi'],
            ];
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
                $this->email->from('qsenweb@gmail.com', $namaAplikasi['nama_aplikasi']);
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
        } else if ($notif['media_id'] == 2) {
            $notif1 = str_replace("<p>", "", $notif['isi']);
            $notif2 = str_replace("</p>", "", $notif1);
            $pesan = '<b>' . $notif['judul'] . '</b>' . PHP_EOL . $notif2 . PHP_EOL . '<i> notifikasi ini dikirim dari aplikasi : ' . $namaAplikasi['nama_aplikasi'] . '</i>';

            $secret_token = "1962226292:AAGcBqfrYjaZi9ViByYFmIRLxXh-LgC-u-A"; //token bot
            foreach ($pengguna as $row) {
                if ($row['userid_telegram'] != NULL) {
                    $url = "https://api.telegram.org/bot" . $secret_token . "/sendMessage?parse_mode=html&chat_id=" . $row['userid_telegram'];
                    $url = $url . "&text=" . urlencode($pesan);
                    $ch = curl_init();
                    $optArray = array(
                        CURLOPT_URL => $url,
                        CURLOPT_RETURNTRANSFER => true
                    );
                    curl_setopt_array($ch, $optArray);
                    $result = curl_exec($ch);
                    curl_close($ch);
                    $this->notif->setStatusKirim($idNotif, $row['id_pengguna']);
                }
            }
        }

        if ($this->notif->setStatusNotif($idNotif)) {
            $this->session->set_flashdata('message', pesanSukses('Notifikasi berhasil dikirim!'));
        } else {
            $this->session->set_flashdata('message', pesanGagal('Notifikasi gagal dikirim!'));
        }
        redirect('notifikasi/index/' . $idAplikasi);
    }

    /**
     * Function selectUser() digunakan untuk mengambil data penguna yang menerima notifikasi
     * dalam bentuk data json
     */
    public function selectUser($idNotif)
    {
        $penerima = $this->notif->getPenerimabynotif($idNotif);
        echo json_encode($penerima);
    }

    /**
     * Function storeIdtele() digunakan untuk menyimpan data id telegram dari pengguna
     */
    public function storeIdtele()
    {
        $user_id = $this->input->post('user_id');
        $userid_telegram = $this->input->post('userid_telegram');
        $this->pengguna->updateIDtelegram($user_id, $userid_telegram);
    }
}
