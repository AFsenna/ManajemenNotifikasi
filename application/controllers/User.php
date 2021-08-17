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
                'password' => $session_data['password'],
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
        $data['aplikasi'] = $this->UserModel->myAplikasi($session_data['id_user']);
        $data['allApp'] = $this->UserModel->getAplikasi($session_data['id_user']);

        $this->load->view('Template/header', $data);
        $this->load->view('Template/sidebar', $data);
        $this->load->view('Template/topbar', $data);
        $this->load->view('User/aplikasi', $data);
        $this->load->view('Template/footer');
    }

    /**
     * Function storeAplikasi digunakan untuk menyimpan aplikasi baru milik user
     */
    public function addAplikasi()
    {
        $this->form_validation->set_rules('aplikasi', 'Application', 'required|trim');
        if ($this->form_validation->run() == false) {
            $this->aplikasi();
        } else {
            $aplikasi = $this->input->post('aplikasi');
            $session_data = $this->session->userdata('datauser');
            $id_user = $session_data['id_user'];
            $data = [
                'nama_aplikasi' => $aplikasi,
                'user_id' => $id_user,
                'status' => 1
            ];
            $this->UserModel->storeAplikasi($data);
            $this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
                New Application added!
            </div>');
            redirect('User/aplikasi');
        }
    }

    /**
     * Function aktifkan digunakan untuk mengaktifkan aplikasi
     */

    public function aktifkan($id)
    {
        $this->UserModel->prosesAktifkan($id);
        $this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
                Application has been enabled!
            </div>');
        redirect('User/aplikasi');
    }

    /**
     * Function nonAktifkan digunakan untuk mengaktifkan aplikasi
     */

    public function nonAktifkan($id)
    {
        $this->UserModel->prosesNonAktifkan($id);
        $this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
                Application has been disabled!
            </div>');
        redirect('User/aplikasi');
    }

    /**
     * Function editAplikasi digunakan untuk mengubah data aplikasi yang sudah ada
     */
    public function editAplikasi($id)
    {
        $this->form_validation->set_rules('aplikasi', 'Application', 'required');
        if ($this->form_validation->run() == false) {
            $this->aplikasi();
        } else {
            $aplikasi = $this->input->post('aplikasi');
            $this->UserModel->updateAplikasi($id, $aplikasi);
            $this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
                Application updated!
            </div>');
            redirect('User/aplikasi');
        }
    }

    /**
     * Function deleteAplikasi digunakan menghapus aplikasi yang dipilih
     * dan dengan syarat belum ada pengguna yang terdaftar
     */

    public function deleteAplikasi($id)
    {
        $cek = $this->UserModel->cekPenggunaApp($id);
        if ($cek) {
            $this->session->set_flashdata('message', '
            <div class="alert alert-danger" role="alert">
                You cant delete this Application!
            </div>');
            redirect('User/aplikasi');
        } else {
            $this->UserModel->prosesDeleteAplikasi($id);
            $this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
                Application deleted!
            </div>');
            redirect('User/aplikasi');
        }
    }

    /**
     * Function pengguna digunakan untuk menuju tampilan pengguna
     */

    public function pengguna($namaAplikasi, $idAplikasi)
    {
        $data['title'] = "Pengguna Aplikasi $namaAplikasi";
        $data['namaAplikasi'] = $namaAplikasi;

        $session_data = $this->session->userdata('datauser');

        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $data['aplikasi'] = $this->UserModel->myAplikasi($session_data['id_user']);
        $data['id_aplikasi'] = $idAplikasi;
        $data['pengguna'] = $this->UserModel->getPengguna($idAplikasi);

        $this->load->view('Template/header', $data);
        $this->load->view('Template/sidebar', $data);
        $this->load->view('Template/topbar', $data);
        $this->load->view('User/pengguna', $data);
        $this->load->view('Template/footer');
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
            $this->pengguna($namaAplikasi, $idAplikasi);
        } else {
            $nama = $this->input->post('nama');
            $phone = $this->input->post('phone');
            $email = $this->input->post('email');

            $data = [
                'nama_pengguna' => $nama,
                'notelp_pengguna' => $phone,
                'email_pengguna' => $email,
                'aplikasi_id' => $idAplikasi
            ];
            $this->UserModel->prosesStorePengguna($data);
            $this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
                New Application user added!
            </div>');
            redirect('User/pengguna/' . $namaAplikasi . '/' . $idAplikasi);
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
            $this->pengguna($namaAplikasi, $idAplikasi);
        } else {
            $nama = $this->input->post('nama');
            $phone = $this->input->post('phone');
            $email = $this->input->post('email');
            $set = [
                'nama_pengguna' => $nama,
                'notelp_pengguna' => $phone,
                'email_pengguna' => $email,
            ];
            $this->UserModel->updatePengguna($idPengguna, $set);
            $this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
                Application user updated!
            </div>');
            redirect('User/pengguna/' . $namaAplikasi . '/' . $idAplikasi);
        }
    }

    /**
     * Function deletePengguna digunakan menghapus aplikasi yang dipilih
     * dan dengan syarat belum ada pengguna yang terdaftar
     */

    public function deletePengguna($namaAplikasi, $idAplikasi, $id)
    {
        $this->UserModel->prosesDeletePengguna($id);
        $this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
                Application user deleted!
            </div>');
        redirect('User/pengguna/' . $namaAplikasi . '/' . $idAplikasi);
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
                $this->session->set_flashdata('message', '
                <div class="alert alert-danger" role="alert">
                    Wrong current password!
                </div>');
                redirect('User/changepassword');
            } else {
                if ($password == $newpassword) {
                    $this->session->set_flashdata('message', '
                    <div class="alert alert-danger" role="alert">
                        New password cannot be the same as current password!
                    </div>');
                    redirect('User/changepassword');
                } else {
                    $passwordhash = password_hash($newpassword, PASSWORD_DEFAULT);
                    $this->UserModel->prosesUpdatePassword($passwordhash, $session_data['email']);
                    $this->session->set_flashdata('message', '
                    <div class="alert alert-success" role="alert">
                        Password changed!
                    </div>');
                    redirect('User/changepassword');
                }
            }
        }
    }
}
