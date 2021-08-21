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
        $data['roles'] = $this->AdminModel->getRole();

        $this->load->view('Template/header', $data);
        $this->load->view('Template/sidebar', $data);
        $this->load->view('Template/topbar', $data);
        $this->load->view('Admin/role', $data);
        $this->load->view('Template/footer');
    }

    /**
     * Function storeRole digunakan untuk menyimpan role baru
     */
    public function storeRole()
    {
        $this->form_validation->set_rules('role', 'Role', 'required');
        if ($this->form_validation->run() == false) {
            $this->role();
        } else {
            $role = $this->input->post('role');
            $this->AdminModel->storeRole($role);
            $this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
                New menu added!
            </div>');
            redirect('Admin/role');
        }
    }

    /**
     * Function editRole digunakan untuk mengubah data role yang sudah ada
     */
    public function editRole($id)
    {
        $this->form_validation->set_rules('role', 'Role', 'required');
        if ($this->form_validation->run() == false) {
            $this->role();
        } else {
            $role = $this->input->post('role');
            $this->AdminModel->updateRole($id, $role);
            $this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
                Role updated!
            </div>');
            redirect('Admin/role');
        }
    }

    /**
     * Function deleteRole digunakan untuk menghapus role yang dipilih
     * dan dengan syarat belum dipakai di user
     */

    public function deleteRole($id)
    {
        $cek = $this->AdminModel->cekRoleUser($id);
        if ($cek) {
            $this->session->set_flashdata('message', '
            <div class="alert alert-danger" role="alert">
                You cant delete this role!
            </div>');
            redirect('Admin/role');
        } else {
            $this->AdminModel->prosesDeleteRole($id);
            $this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
                Role deleted!
            </div>');
            redirect('Admin/role');
        }
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
        $data['dataUser'] = $this->AdminModel->getUser();
        $data['aplikasi'] = $this->AdminModel->AplikasiUser();

        $this->load->view('Template/header', $data);
        $this->load->view('Template/sidebar', $data);
        $this->load->view('Template/topbar', $data);
        $this->load->view('Admin/user', $data);
        $this->load->view('Template/footer');
    }

    /**
     * Function aplikasi digunakan untuk melihat tampilan aplikasi yang terdaftar
     */
    public function aplikasi()
    {
        $data['title'] = 'Aplikasi';

        $session_data = $this->session->userdata('datauser');

        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $data['allApp'] = $this->AdminModel->getAplikasi();

        $this->load->view('Template/header', $data);
        $this->load->view('Template/sidebar', $data);
        $this->load->view('Template/topbar', $data);
        $this->load->view('User/aplikasi', $data);
        $this->load->view('Template/footer');
    }
}
