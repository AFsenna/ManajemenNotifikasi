<?php

class UserModel extends CI_Model
{
    /**
     * Function myAplikasi digunakan untuk mendapatkan data aplikasi yang dimiliki user
     */
    public function myAplikasi($id)
    {
        $query = $this->db->get_where('aplikasi', ['user_id' => $id]);
        return $query->result_array();
    }

    /**
     * Function updateProfile digunakan untuk mengeupdate data user di database
     */
    public function updateProfile($data, $id)
    {
        $this->db->where('id_user', $id);
        $this->db->update('user', $data);
    }
}
