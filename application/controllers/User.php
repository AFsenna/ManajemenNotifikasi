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
        $data['aplikasi'] = $this->UserModel->myAplikasi($session_data['id_user']);

        $this->load->view('Template/header', $data);
        $this->load->view('Template/sidebar', $data);
        $this->load->view('Template/topbar', $data);
        $this->load->view('User/index', $data);
        $this->load->view('Template/footer');
    }

    /**
     * Function editProfile digunakan untuk mengedit profile user
     */
    public function editProfile()
    {
        $session_data = $this->session->userdata('datauser');
        $this->form_validation->set_rules('namalengkap', 'Full Name', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');

        if ($this->input->post('username') != $session_data['username']) {
            $this->form_validation->set_rules(
                'username',
                'Username',
                'required|trim|is_unique[user.username]',
                [
                    'is_unique' => 'This username has already registered!'
                ]
            );
        } else {
            $this->form_validation->set_rules('username', 'Username', 'required|trim');
        }

        if ($this->input->post('email') != $session_data['email']) {
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
                'is_unique' => 'This email has already registered!'
            ]);
        } else {
            $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        }

        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $namalengkap = $this->input->post('namalengkap');
            $notelp = $this->input->post('phone');
            $username = $this->input->post('username');
            $email = $this->input->post('email');
            $id = $session_data['id_user'];
            $set = [
                'nama_lengkap' => $namalengkap,
                'notelp' => $notelp,
                'username' => $username,
                'email' => $email,
            ];
            $this->UserModel->updateProfile($set, $id);
            $this->session->unset_userdata('datauser');
            $data = [
                'nama_lengkap' => ucwords($namalengkap),
                'username' => ucfirst($username),
                'notelp' => $notelp,
                'email' => $email,
                'status' => $session_data['status'],
                'role_id' => $session_data['role_id'],
                'id_user' => $session_data['id_user']
            ];
            $this->session->set_userdata('datauser', $data);
            $this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
                Profile edited!
            </div>');
            redirect('User');
        }
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

    public function pengguna($namaAplikasi, $id)
    {
        $data['title'] = "Pengguna Aplikasi $namaAplikasi";
        $data['namaAplikasi'] = $namaAplikasi;

        $session_data = $this->session->userdata('datauser');

        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $data['aplikasi'] = $this->UserModel->myAplikasi($session_data['id_user']);

        $this->load->view('Template/header', $data);
        $this->load->view('Template/sidebar', $data);
        $this->load->view('Template/topbar', $data);
        $this->load->view('User/pengguna', $data);
        $this->load->view('Template/footer');
    }

    /**
     * Function notifikasi digunakan untuk menuju tampilan notifikasi
     */
    public function notifikasi($namaAplikasi, $id)
    {
        $data['title'] = "Notifikasi Milik $namaAplikasi";
        $data['namaAplikasi'] = $namaAplikasi;

        $session_data = $this->session->userdata('datauser');

        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $data['aplikasi'] = $this->UserModel->myAplikasi($session_data['id_user']);

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
