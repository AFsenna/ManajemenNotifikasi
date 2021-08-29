<?php

class TokenModel extends CI_Model
{
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
        $query = $this->db->get_where('token', ['token' => $token]);
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
     * Function storeToken digunakan untuk menyimpan data token
     */
    public function storeToken($user_token)
    {
        if ($this->db->insert('token', $user_token)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function deleteToken digunakan untuk menghapus token yang sudah digunakan
     */
    public function deleteToken($email)
    {
        if ($this->db->delete('token', ['email' => $email])) {
            return true;
        } else {
            return false;
        }
    }
}
