<?php

/**
 * defined('BASEPATH') or exit('No direct script access allowed');
 * Berfungsi untuk memproteksi agar script yang kita buat tidak dapat diakses secara langsung 
 * dan harus melalui www.namaweb.com/controller
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    protected $session_data;

    /**
     * Function __construct() merupakan fungsi yang di eksekusi pertama kali saat 
     * Admin Controller dipanggil/digunakan
     */
    public function __construct()
    {
        parent::__construct();

        $this->session_data = $this->session->userdata('datauser');
        $this->load->model('AdminModel', 'adm');
        $this->load->model('AplikasiModel', 'apk');

        deleteTokenEXP();
        cekAccessAdmin();
    }

    /**
     * Function index digunakan untuk menuju tampilan awal admin (dashboard) 
     */

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['jumlahAplikasi'] = $this->adm->countApp();
        $data['notifTerkirim'] = $this->adm->countTerkirim();
        $data['user'] = $this->adm->countUser();
        $data['blmTerkirim'] = $this->adm->countBLMterkirim();
        $data['notifikasi'] = $this->adm->countNotifikasi();
        $data['role_id'] = $this->session_data['role_id'];
        $data['nama'] = $this->session_data['nama_lengkap'];

        $this->template->render('Admin/index', $data);
    }

    /**
     * Function role digunakan untuk menuju tampilan user
     */
    public function user()
    {
        $data['title'] = 'Data user';
        $data['role_id'] = $this->session_data['role_id'];
        $data['nama'] = $this->session_data['nama_lengkap'];
        $data['dataUser'] = $this->adm->getUser();
        $data['aplikasi'] = $this->apk->getAll();

        $this->template->render('Admin/user', $data);
    }

    /**
     * Function aplikasi digunakan untuk melihat tampilan aplikasi yang terdaftar
     */
    public function aplikasi()
    {
        $data['title'] = 'Aplikasi';
        $data['role_id'] = $this->session_data['role_id'];
        $data['nama'] = $this->session_data['nama_lengkap'];
        $data['allApp'] = $this->apk->getDetailAplikasi();

        $this->template->render('Aplikasi/index', $data);
    }
}
