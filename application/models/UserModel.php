<?php

class UserModel extends CI_Model
{
    /**
     * Function updateProfile digunakan untuk mengeupdate data user di database
     */
    public function updateProfile($data, $id)
    {
        $this->db->where('id_user', $id);
        $this->db->update('user', $data);
    }

    /**
     * Function prosesUpdatePassword digunakan untuk mengupdate password user yang ada di database
     */
    public function prosesUpdatePassword($password, $email)
    {
        $this->db->set('password', $password);
        $this->db->where('email', $email);
        $this->db->update('user');
    }
}
