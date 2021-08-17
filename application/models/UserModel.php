<?php

class UserModel extends CI_Model
{
    /**
     * Function myAplikasi digunakan untuk mendapatkan data aplikasi yang dimiliki user dengan status aktif
     */
    public function myAplikasi($id)
    {
        $query = $this->db->get_where('aplikasi', ['user_id' => $id, 'status' => 1]);
        return $query->result_array();
    }

    /**
     * Function getAplikasi($id) digunakan untuk mendapatkan seluruh data aplikasi milik user
     */

    public function getAplikasi($id)
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

    /**
     * Function storeAplikasi digunakan untuk menyimpan aplikasi baru ke database
     */
    public function storeAplikasi($data)
    {
        $this->db->insert('aplikasi', $data);
    }

    /**
     * Function updateAplikasi digunakan untuk mengubah data aplikasi yang ada di database
     */
    public function updateAplikasi($id, $aplikasi)
    {
        $this->db->set('nama_aplikasi', $aplikasi);
        $this->db->where('id_aplikasi', $id);
        $this->db->update('aplikasi');
    }

    /**
     * Function cekPenggunaApp digunakan untuk mengecek 
     * apakah aplikasi sudah menjadi foreign key di tabel pengguna_aplikasi
     */
    public function cekPenggunaApp($id)
    {
        return $this->db->get_where('pengguna_aplikasi', ['aplikasi_id' => $id])->row_array();
    }

    /**
     * Function prosesDeleteAplikasi digunakan untuk menghapus aplikasi di database berdasarkan id yang dipilih
     */
    public function prosesDeleteAplikasi($id)
    {
        $this->db->delete('aplikasi', ['id_aplikasi' => $id]);
    }

    /**
     * Function prosesAktifkan digunakan untuk mengaktifkan aplikasi dengan cara mengubah status menjadi 1
     */
    public function prosesAktifkan($id)
    {
        $this->db->set('status', 1);
        $this->db->where('id_aplikasi', $id);
        $this->db->update('aplikasi');
    }

    /**
     * Function prosesNonAktifkan digunakan untuk non-aktifkan aplikasi dengan cara mengubah status menjadi 0
     */
    public function prosesNonAktifkan($id)
    {
        $this->db->set('status', 0);
        $this->db->where('id_aplikasi', $id);
        $this->db->update('aplikasi');
    }

    /**
     * Function getPengguna digunakan untuk mengambil data seluruh pengguna dalam salah satu aplikasi
     */
    public function getPengguna($idAplikasi)
    {
        $query = $this->db->get_where('pengguna_aplikasi', ['aplikasi_id' => $idAplikasi]);
        return $query->result_array();
    }

    /**
     * Function prosesStorePengguna digunakan untuk menyimpan pengguna aplikasi baru ke database
     */
    public function prosesStorePengguna($data)
    {
        $this->db->insert('pengguna_aplikasi', $data);
    }

    /**
     * Function updatePengguna digunakan untuk mengubah data pengguna aplikasi yang ada di database
     */
    public function updatePengguna($idPengguna, $set)
    {
        $this->db->where('id_pengguna', $idPengguna);
        $this->db->update('pengguna_aplikasi', $set);
    }

    /**
     * Function prosesDeletePengguna digunakan 
     * untuk menghapus pengguna aplikasi di database berdasarkan id yang dipilih
     */
    public function prosesDeletePengguna($id)
    {
        $this->db->delete('pengguna_aplikasi', ['id_pengguna' => $id]);
    }
}
