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
     * Function getToken digunakan untuk mendapatkan data token berdasarkan token yang dikirimkan
     * melalui url yang didapat di email user
     */
    public function getToken($token)
    {
        return $this->db->get_where('token', ['token' => $token])->row_array();
    }

    /**
     * Function getToken digunakan untuk mendapatkan data token berdasarkan token yang dikirimkan
     * melalui url yang didapat di email user
     */
    public function getTokenbytk($token)
    {
        $query = $this->db->get_where('user', ['token' => $token]);
        return $query->result_array();
    }
    /**
     * Function getToken2 digunakan untuk mendapatkan data token berdasarkan email yang dikirimkan
     * melalui url yang didapat di email user
     */
    public function getTokenbyem($email)
    {
        return $this->db->get_where('token', ['email' => $email])->row_array();
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

    /**
     * Function updatePassword digunakan untuk mengupdate password baru user
     */
    public function updatePassword($password, $email)
    {
        $this->db->set('password', $password);
        $this->db->where('email', $email);
        $this->db->update('user');
    }
}
