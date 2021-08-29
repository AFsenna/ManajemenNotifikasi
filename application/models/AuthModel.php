<?php

class AuthModel extends CI_Model
{
    /**
     * Function login digunakan untuk memanggil data pada database 
     * dimana username dan password didapat dari inputan user
     */
    public function login($username)
    {
        return $this->db->get_where('user', ['username' => $username])->row_array();
    }

    /**
     * Function getUser digunakan untuk mendapatkan data user berdasarkan email yang dikirimkan 
     * melalui url yang didapat di email
     */
    public function getUser($email)
    {
        $query = $this->db->get_where('user', ['email' => $email]);
        return $query->result_array();
    }

    /**
     * Function cekUser digunakan untuk mengecek apakah user yang melakukan forgot password sudah terdaftar 
     * dan apakah statusnya sudah aktif
     */
    public function cekUser($email)
    {
        $where = [
            'email' => $email,
            'status' => 1
        ];

        $query = $this->db->get_where('user', $where);
        return $query->result_array();
    }

    /**
     * Function prosesStore digunakan untuk menyimpan data user dan data token ketika register
     */
    public function prosesStore($data)
    {
        if ($this->db->insert('user', $data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function UpdateStatus digunakan untuk mengupdate status user dari 0 menjadi 1
     */
    public function UpdateStatus($email)
    {
        $this->db->set('status', 1);
        $this->db->where('email', $email);
        if ($this->db->update('user')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function deleteUser digunakan untuk menghapus user yang tokennya sudah expired 
     */
    public function deleteUser($email)
    {
        if ($this->db->delete('user', ['email' => $email])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function updatePassword digunakan untuk mengupdate password baru user
     */
    public function updatePassword($password, $email)
    {
        $this->db->set('password', $password);
        $this->db->where('email', $email);
        if ($this->db->update('user')) {
            return true;
        } else {
            return false;
        }
    }
}
