<?php

class MediaModel extends CI_Model
{
    /**
     * Function getMedia digunakan untuk mengambil seluruh data media yang ada di database
     */
    public function getMedia()
    {
        $query = $this->db->get('media');
        return $query->result_array();
    }
}
