<?php

class AplikasiModel extends CI_Model
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
     * Function getAll digunakan untuk mendapatkan seluruh data aplikasi
     */
    public function getAll()
    {
        return $this->db->get('aplikasi')->result_array();
    }

    /**
     * Function getDetailAplikasi digunakan untuk mendapatkan data aplikasi dan jumlah pengguna aplikasi tersebut
     */
    public function getDetailAplikasi()
    {
        $this->db->select('aplikasi.*');
        $this->db->select('COALESCE(COUNT(pengguna_aplikasi.nama_pengguna),0) AS jumlah_pengguna');
        $this->db->from('aplikasi');
        $this->db->join('pengguna_aplikasi', 'aplikasi.id_aplikasi = pengguna_aplikasi.aplikasi_id', 'left');
        $this->db->group_by('aplikasi.id_aplikasi');
        $query = $this->db->get();
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
     * Function storeAplikasi digunakan untuk menyimpan aplikasi baru ke database
     */
    public function storeAplikasi($data)
    {
        if ($this->db->insert('aplikasi', $data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function updateAplikasi digunakan untuk mengubah data aplikasi yang ada di database
     */
    public function updateAplikasi($id, $aplikasi)
    {
        $this->db->set('nama_aplikasi', $aplikasi);
        $this->db->where('id_aplikasi', $id);
        if ($this->db->update('aplikasi')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function prosesDeleteAplikasi digunakan untuk menghapus aplikasi di database berdasarkan id yang dipilih
     */
    public function prosesDeleteAplikasi($id)
    {
        if ($this->db->delete('aplikasi', ['id_aplikasi' => $id])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function prosesAktifkan digunakan untuk mengaktifkan aplikasi dengan cara mengubah status menjadi 1
     */
    public function prosesAktifkan($id)
    {
        $this->db->set('status', 1);
        $this->db->where('id_aplikasi', $id);
        if ($this->db->update('aplikasi')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function prosesNonAktifkan digunakan untuk non-aktifkan aplikasi dengan cara mengubah status menjadi 0
     */
    public function prosesNonAktifkan($id)
    {
        $this->db->set('status', 0);
        $this->db->where('id_aplikasi', $id);
        if ($this->db->update('aplikasi')) {
            return true;
        } else {
            return false;
        }
    }
}
