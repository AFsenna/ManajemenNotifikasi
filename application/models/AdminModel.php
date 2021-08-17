<?php

class AdminModel extends CI_Model
{
    /**
     * Function getRole digunakan untuk mendapatkan seluruh data role
     */
    public function getRole()
    {
        return $this->db->get('role')->result_array();
    }

    /**
     * Function storeRole digunakan untuk menyimpan role baru ke database
     */
    public function storeRole($role)
    {
        $this->db->insert('role', ['nama' => $role]);
    }

    /**
     * Function updateRole digunakan untuk mengubah data role yang ada di database
     */
    public function updateRole($id, $role)
    {
        $this->db->set('nama', $role);
        $this->db->where('id_role', $id);
        $this->db->update('role');
    }

    /**
     * Function cekRoleUser digunakan untuk mengecek apakah role sudah menjadi foreign key di tabel user
     */
    public function cekRoleUser($id)
    {
        return $this->db->get_where('user', ['role_id' => $id])->row_array();
    }

    /**
     * Function deleteRole digunakan untuk menghapus role di database berdasarkan id yang dipilih
     */
    public function deleteRole($id)
    {
        $this->db->delete('role', ['id_role' => $id]);
    }
}
