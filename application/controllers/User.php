<?php

/**
 * defined('BASEPATH') or exit('No direct script access allowed');
 * Berfungsi untuk memproteksi agar script yang kita buat tidak dapat diakses secara langsung 
 * dan harus melalui www.namaweb.com/controller
 */

defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    /**
     * Function __construct() merupakan fungsi yang di eksekusi pertama kali 
     * saat AuthController dipanggil
     */

    public function __construct()
    {
        parent::__construct();
        $this->load->model('UserModel');
        deleteTokenEXP();
    }

    /**
     * function index digunakan untuk menuju tampilan profile
     */

    public function index()
    {
        $data['title'] = 'Profile';
        $session_data = $this->session->userdata('datauser');
        $data['nama'] = $session_data['nama_lengkap'];
        $data['username'] = $session_data['username'];
        $data['email'] = $session_data['email'];
        $data['notelp'] = $session_data['notelp'];
        $data['role_id'] = $session_data['role_id'];

        $this->load->view('Template/header', $data);
        $this->load->view('Template/sidebar', $data);
        $this->load->view('Template/topbar', $data);
        $this->load->view('User/index', $data);
        $this->load->view('Template/footer');
    }

    /**
     * Function aplikasi digunakan untuk menuju tampilan aplikasi
     */
    public function aplikasi()
    {
        $data['title'] = 'Aplikasi';
        $session_data = $this->session->userdata('datauser');
        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $this->load->view('Template/header', $data);
        $this->load->view('Template/sidebar', $data);
        $this->load->view('Template/topbar', $data);
        $this->load->view('User/aplikasi');
        $this->load->view('Template/footer');
    }

    /**
     * Function pengguna digunakan untuk menuju tampilan pengguna
     */

    public function pengguna($namaAplikasi)
    {
        $data['title'] = "Pengguna Aplikasi $namaAplikasi";
        $data['namaAplikasi'] = $namaAplikasi;
        $session_data = $this->session->userdata('datauser');
        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $this->load->view('Template/header', $data);
        $this->load->view('Template/sidebar', $data);
        $this->load->view('Template/topbar', $data);
        $this->load->view('User/pengguna', $data);
        $this->load->view('Template/footer');
    }

    /**
     * Function notifikasi digunakan untuk menuju tampilan notifikasi
     */
    public function notifikasi($namaAplikasi)
    {
        $data['title'] = "Notifikasi Milik $namaAplikasi";
        $data['namaAplikasi'] = $namaAplikasi;
        $session_data = $this->session->userdata('datauser');
        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $this->load->view('Template/header', $data);
        $this->load->view('Template/sidebar', $data);
        $this->load->view('Template/topbar', $data);
        $this->load->view('User/notifikasi', $data);
        $this->load->view('Template/footer');
    }

    /**
     * Function notifikasi digunakan untuk menuju tampilan notifikasi
     */
    public function changepassword()
    {
        $data['title'] = "Change Password";
        $session_data = $this->session->userdata('datauser');
        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $this->load->view('Template/header', $data);
        $this->load->view('Template/sidebar', $data);
        $this->load->view('Template/topbar', $data);
        $this->load->view('User/changepassword');
        $this->load->view('Template/footer');
    }
}
