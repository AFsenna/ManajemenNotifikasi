<?php

class ReportModel extends CI_Model
{
    /**
     * Function getUser digunakan untuk mendapatkan seluruh data user
     */
    public function getUser()
    {
        $where = [
            'role_id' => 2,
            'status' => 1
        ];
        $query = $this->db->get_where('user', $where);
        return $query->result_array();
    }

    /**
     * Function getAplikasiAll digunakan untuk mendapatkan data aplikasi yang terdaftar dan jumlah penggunanya
     */
    public function getAplikasiAll()
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
     * Function getAplikasi digunakan untuk mendapatkan data aplikasi yang dimiliki user dengan status aktif
     */
    public function getAplikasi($id)
    {
        $query = $this->db->get_where('aplikasi', ['user_id' => $id, 'status' => 1]);
        return $query->result_array();
    }

    /**
     * function getPengguna digunakan untuk mendapatkan data pengguna dari aplikasi yang aktif
     */
    public function getPengguna($start_date, $end_date)
    {
        $this->db->select('pengguna_aplikasi.*');
        $this->db->from('pengguna_aplikasi');
        $this->db->where('tanggal_dibuat BETWEEN "' . date('Y-m-d', strtotime($start_date)) . '" and "' . date('Y-m-d', strtotime($end_date)) . '"');
        $this->db->order_by('tanggal_dibuat ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * function getNotifikasi digunakan untuk mendapatkan data notifikasi
     */
    public function getNotifikasi($start_date, $end_date)
    {
        $this->db->select('notifikasi.*');
        $this->db->from('notifikasi');
        $this->db->where('notifikasi.tanggalDibuat BETWEEN "' . date('Y-m-d', strtotime($start_date)) . '" and "' . date('Y-m-d', strtotime($end_date)) . '"');
        $this->db->order_by('notifikasi.tanggalDibuat ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * function getPenerima digunakan untuk mendapatkan data penerima dari notifikasi
     */
    public function getPenerima()
    {
        $this->db->select('pengguna_aplikasi.*');
        $this->db->select('detail_notifikasi.notifikasi_id');
        $this->db->from('detail_notifikasi');
        $this->db->join('pengguna_aplikasi', 'detail_notifikasi.pengguna_id = pengguna_aplikasi.id_pengguna');
        $query = $this->db->get();
        return $query->result_array();
    }
}
