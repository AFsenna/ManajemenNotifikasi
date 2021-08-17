<?php

/**
 * defined('BASEPATH') or exit('No direct script access allowed');
 * Berfungsi untuk memproteksi agar script yang kita buat tidak dapat diakses secara langsung 
 * dan harus melalui www.namaweb.com/controller
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    /**
     * Function __construct() merupakan fungsi yang di eksekusi pertama kali 
     * saat AuthController dipanggil
     */

    public function __construct()
    {
        parent::__construct();
        $this->load->model('AdminModel');
        deleteTokenEXP();
    }

    /**
     * Function index digunakan untuk menuju tampilan awal admin (dashboard)
     */

    public function index()
    {
        $data['title'] = 'Dashboard';
        $session_data = $this->session->userdata('datauser');
        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $this->load->view('Template/header', $data);
        $this->load->view('Template/sidebar', $data);
        $this->load->view('Template/topbar', $data);
        $this->load->view('Admin/index');
        $this->load->view('Template/footer');
    }

    /**
     * Function role digunakan untuk menuju tampilan role
     */
    public function role()
    {
        $data['title'] = 'Role';
        $session_data = $this->session->userdata('datauser');
        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $this->load->view('Template/header', $data);
        $this->load->view('Template/sidebar', $data);
        $this->load->view('Template/topbar', $data);
        $this->load->view('Admin/role');
        $this->load->view('Template/footer');
    }

    /**
     * Function role digunakan untuk menuju tampilan user
     */
    public function user()
    {
        $data['title'] = 'Data user';
        $session_data = $this->session->userdata('datauser');
        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $this->load->view('Template/header', $data);
        $this->load->view('Template/sidebar', $data);
        $this->load->view('Template/topbar', $data);
        $this->load->view('Admin/user');
        $this->load->view('Template/footer');
    }
}
