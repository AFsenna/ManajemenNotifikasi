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
     * saat User controller dipanggil
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('UserModel');
        $this->load->model('AplikasiModel', 'apk');
        $this->load->model('PenggunaAppModel', 'pengguna');

        cekAccessUser();
    }

    /**
     * function index digunakan untuk menuju tampilan profile
     */
    public function index()
    {
        $session_data = $this->session->userdata('datauser');

        $data['title'] = 'Profile';
        $data['nama'] = $session_data['nama_lengkap'];
        $data['username'] = $session_data['username'];
        $data['email'] = $session_data['email'];
        $data['notelp'] = $session_data['notelp'];
        $data['role_id'] = $session_data['role_id'];
        $data['aplikasi'] = $this->apk->myAplikasi($session_data['id_user']);

        $this->template->render('user/index', $data);
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
                'password' => $session_data['password'],
                'status' => $session_data['status'],
                'role_id' => $session_data['role_id'],
                'id_user' => $session_data['id_user']
            ];
            $this->session->set_userdata('datauser', $data);
            $this->session->set_flashdata('message', pesanSukses('Profil berhasil diedit!'));

            redirect('User');
        }
    }

    /**
     * Function notifikasi digunakan untuk menuju tampilan notifikasi
     */
    public function changepassword()
    {
        $session_data = $this->session->userdata('datauser');
        $data['title'] = "Change Password";
        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $data['aplikasi'] = $this->apk->myAplikasi($session_data['id_user']);

        $this->template->render('user/changepassword', $data);
    }

    /**
     * Function updatePassword digunakan untuk mengubah password user 
     * dengan syarat harus memasukkan password yang sebelumnya
     */
    public function updatePassword()
    {
        $this->form_validation->set_rules('password', 'Curent Password', 'required|trim');
        $this->form_validation->set_rules('newpassword1', 'New Password', 'required|trim|min_length[3]|max_length[6]|matches[newpassword2]');
        $this->form_validation->set_rules('newpassword2', 'Confirm New Password', 'required|trim|matches[newpassword1]');

        if ($this->form_validation->run() == false) {
            $this->changepassword();
        } else {
            $session_data = $this->session->userdata('datauser');
            $oldpassword = $session_data['password'];
            $password = $this->input->post('password');
            $newpassword = $this->input->post('newpassword1');
            if (!password_verify($password, $oldpassword)) {
                $this->session->set_flashdata('message', pesanGagal('Wrong current password!!'));
                redirect('User/changepassword');
            } else {
                if ($password == $newpassword) {
                    $this->session->set_flashdata('message', pesanGagal('Password baru tidak boleh sama dengan password lama!'));
                    redirect('User/changepassword');
                } else {
                    $passwordhash = password_hash($newpassword, PASSWORD_DEFAULT);
                    $this->UserModel->prosesUpdatePassword($passwordhash, $session_data['email']);
                    $this->session->set_flashdata('message', pesanSukses('Password berhasil diubah!!'));
                    redirect('User/changepassword');
                }
            }
        }
    }
}
