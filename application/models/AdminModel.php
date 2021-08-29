<?php

class AdminModel extends CI_Model
{
    /**
     * Function countApp digunakan untuk menghitung banyaknya aplikasi yang terdaftar
     */
    public function countApp()
    {
        $this->db->select('COALESCE(COUNT(aplikasi.nama_aplikasi),0) AS jumlah_aplikasi');
        $this->db->from('aplikasi');
        return $this->db->get()->row_array();
    }

    /**
     * Function countTerkirim digunakan untuk menghitung banyaknya notifikasi yang sudah terkirim
     */
    public function countTerkirim()
    {
        $this->db->select('COALESCE(COUNT(notifikasi.judul),0) AS jumlah_notifikasi');
        $this->db->from('notifikasi');
        $this->db->where('status', 1);
        return $this->db->get()->row_array();
    }

    /**
     * Function countUser digunakan untuk menghitung banyaknya user yang aktif
     */
    public function countUser()
    {
        $this->db->select('COALESCE(COUNT(user.nama_lengkap),0) AS jumlah_user');
        $this->db->from('user');
        $this->db->where('status', 1);
        $this->db->where('role_id', 2);
        return $this->db->get()->row_array();
    }

    /**
     * Function countBLMterkirim digunakan untuk menghitung banyaknya notifikasi yang belum terkirim
     */
    public function countBLMterkirim()
    {
        $this->db->select('COALESCE(COUNT(notifikasi.judul),0) AS notifbelum');
        $this->db->from('notifikasi');
        $this->db->where('status', 0);
        return $this->db->get()->row_array();
    }

    /**
     * Function countNotifikasi digunakan untuk menghitung banyaknya notifikasi yang terdaftar perbulan dan pada tahun ini
     */
    public function countNotifikasi()
    {
        $i = 1;
        while ($i < 13) {
            $query = "SELECT COALESCE(COUNT(notifikasi.judul),0) AS jumlahnotif FROM notifikasi WHERE month(tanggalDibuat) = $i AND YEAR(tanggalDibuat)=YEAR(now())";
            $data = $this->db->query($query)->row_array();
            $hasil[$i] = $data['jumlahnotif'];
            $i++;
        }
        return $hasil;
    }

    /**
     * Function getUser digunakan untuk mendapatkan data user yang aktif dan memiliki role user
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
}
