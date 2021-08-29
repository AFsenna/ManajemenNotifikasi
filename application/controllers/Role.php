<?php

/**
 * defined('BASEPATH') or exit('No direct script access allowed');
 * Berfungsi untuk memproteksi agar script yang kita buat tidak dapat diakses secara langsung 
 * dan harus melalui www.namaweb.com/controller
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Controller
{
    /**
     * Function __construct() merupakan fungsi yang di eksekusi pertama kali saat 
     * RoleController dipanggil/digunakan
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('RoleModel', 'role');

        deleteTokenEXP();
        cekAccessAdmin();
    }

    /**
     * Function role digunakan untuk menuju tampilan role
     */
    public function index()
    {
        $session_data = $this->session->userdata('datauser');

        $data['title'] = 'Role';
        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $data['roles'] = $this->role->getRole();

        $this->template->render('Role/index', $data);
    }

    /**
     * Function storeRole digunakan untuk menyimpan role baru
     */
    public function storeRole()
    {
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $role = $this->input->post('role');

            if ($this->role->storeRole($role)) {
                $this->session->set_flashdata('message', pesanSukses('Role berhasil ditambahkan!'));
            } else {
                $this->session->set_flashdata('message', pesanGagal('Role gagal ditambahkan!'));
            }

            redirect('Role');
        }
    }

    /**
     * Function editRole digunakan untuk mengubah data role yang sudah ada
     */
    public function editRole($id)
    {
        $this->form_validation->set_rules('role', 'Role', 'required');

        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $role = $this->input->post('role');

            if ($this->role->updateRole($id, $role)) {
                $this->session->set_flashdata('message', pesanSukses('Role berhasil diupdate!'));
            } else {
                $this->session->set_flashdata('message', pesanGagal('Role gagal diupdate!'));
            }

            redirect('Role');
        }
    }

    /**
     * Function deleteRole digunakan untuk menghapus role yang dipilih
     * dan dengan syarat belum dipakai di user
     */

    public function deleteRole($id)
    {
        $cek = $this->role->cekRoleUser($id);

        if ($cek) {
            $this->session->set_flashdata('message', pesanGagal('Role ini tidak bisa dihapus!'));
        } else {
            if ($this->role->prosesDeleteRole($id)) {
                $this->session->set_flashdata('message', pesanSukses('Role berhasil dihapus!'));
            } else {
                $this->session->set_flashdata('message', pesanGagal('Role gagal dihapus!'));
            }
        }

        redirect('Role');
    }
}
