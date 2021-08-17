<?php

class AuthModel extends CI_Model
{
    /**
     * Function login digunakan untuk memanggil data pada database 
     * dimana username dan password didapat dari inputan user
     */
    public function login($username, $password)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('username', $username);
        $this->db->where('password', $password);
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * Function prosesStore digunakan untuk menyimpan data user dan data token ketika register
     */
    public function prosesStore($data)
    {
        $this->db->insert('user', $data);
    }

    /**
     * Function storeToken digunakan untuk menyimpan data token
     */
    public function storeToken($user_token)
    {
        $this->db->insert('token', $user_token);
    }

    /**
     * Function getUser digunakan untuk mendapatkan data user berdasarkan email yang dikirimkan 
     * melalui url yang didapat di email
     */
    public function getUser($email)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email', $email);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * Function cekUser digunakan untuk mengecek apakah user yang melakukan forgot password sudah terdaftar 
     * dan apakah statusnya sudah aktif
     */
    public function cekUser($email)
    {
        $this->db->select('*');
        $this->db->from('user');
        $this->db->where('email', $email);
        $this->db->where('status', 1);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * Function getToken digunakan untuk mendapatkan data token berdasarkan token yang dikirimkan
     * melalui url yang didapat di email user
     */
    public function getToken($token)
    {
        $this->db->select('*');
        $this->db->from('token');
        $this->db->where('token', $token);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
        } else {
            return false;
        }
    }

    /**
     * Function getToken2 digunakan untuk mendapatkan data token berdasarkan email yang dikirimkan
     * melalui url yang didapat di email user
     */
    public function getToken2($email)
    {
        $this->db->select('*');
        $this->db->from('token');
        $this->db->where('token', $email);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            return $query->row_array();
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
        $this->db->update('user');
    }

    /**
     * Function deleteToken digunakan untuk menghapus token yang sudah digunakan
     */
    public function deleteToken($email)
    {
        $this->db->delete('token', ['email' => $email]);
    }

    /**
     * Function deleteUser digunakan untuk menghapus user yang tokennya sudah expired 
     */
    public function deleteUser($email)
    {
        $this->db->delete('user', ['email' => $email]);
    }
}
