<?php

class NotifikasiModel extends CI_Model
{
    /**
     * Function storeNotifikasi digunakan untuk menyimpan notifikasi di database
     * pada tabel notifikasi dan detail_notifikasi
     */
    public function storeNotifikasi($data, $id)
    {
        $judul = $data['judul'];
        $isinotifikasi = $data['isinotif'];
        $tanggal = $data['tanggal'];
        $isi = [
            'judul' => $judul,
            'isi' => $isinotifikasi,
            'status' => 0,
            'aplikasi_id' => $id,
            'tanggalDibuat' => $tanggal
        ];
        if ($this->db->insert('notifikasi', $isi)) {
            $idNotif = $this->db->insert_id();
            foreach ($data['penerima'] as $row) {
                $this->db->insert('detail_notifikasi', [
                    'pengguna_id' => $row,
                    'notifikasi_id' => $idNotif
                ]);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function ini digunakan untuk mendapatkan data notifikasi berdasarkan idaplikasi yang diinginkan
     */
    public function getNotifikasi($idAplikasi)
    {
        $query = $this->db->get_where('notifikasi', ['aplikasi_id' => $idAplikasi]);
        return $query->result_array();
    }

    /**
     * Function ini digunakan untuk mendapatkan data penerima dari notifikasi
     */
    public function getPenerima()
    {
        $this->db->select('pengguna_aplikasi.*');
        $this->db->select('detail_notifikasi.*');
        $this->db->from('detail_notifikasi');
        $this->db->join('pengguna_aplikasi', 'detail_notifikasi.pengguna_id = pengguna_aplikasi.id_pengguna');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Function ini digunakan untuk mengupdate data notifikasi yang ada di database
     */
    public function updateNotifikasi($data)
    {
        $idNotif = $data['idnotif'];
        $judul = $data['judul'];
        $tanggal = $data['tanggal'];
        $isi = $data['isinotif'];
        $set = [
            'judul' => $judul,
            'isi' => $isi,
            'tanggalDibuat' => $tanggal
        ];
        $this->db->where('id_notifikasi', $idNotif);
        if ($this->db->update('notifikasi', $set)) {
            if ($this->db->delete('detail_notifikasi', ['notifikasi_id' => $idNotif])) {
                foreach ($data['penerima'] as $row) {
                    $this->db->insert('detail_notifikasi', [
                        'pengguna_id' => $row,
                        'notifikasi_id' => $idNotif
                    ]);
                }
            } else {
                return false;
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function ini digunakan untuk menghapus data notifikasi di database
     */
    public function prosesDeleteNotifikasi($id)
    {
        if ($this->db->delete('notifikasi', ['id_notifikasi' => $id])) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function ini digunakan untuk mendapatkan data notifikasi berdasarkan id yang diminta
     */
    public function getNotifikasibyid($idNotif)
    {
        return $this->db->get_where('notifikasi', ['id_notifikasi' => $idNotif])->row_array();
    }

    /**
     * Function ini digunakan untuk mengubah status notifikasi
     */
    public function setStatusNotif($idNotif)
    {
        $set = [
            'status' => 1,
            'tanggalTerkirim' => date("Y-m-d")
        ];
        $this->db->where('id_notifikasi', $idNotif);
        if ($this->db->update('notifikasi', $set)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function ini digunakan untuk mendapatkan data penerima berdasarkan id notifikasi
     */
    public function getPenerimabynotif($idNotif)
    {
        $this->db->select('pengguna_aplikasi.*');
        $this->db->select('detail_notifikasi.*');
        $this->db->from('detail_notifikasi');
        $this->db->where('notifikasi_id', $idNotif);
        $this->db->join('pengguna_aplikasi', 'detail_notifikasi.pengguna_id = pengguna_aplikasi.id_pengguna');
        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Function ini digunakan untuk mengubah status yang ada pada detail notifikasi
     */
    public function setStatusKirim($idNotif, $idPengguna)
    {
        $this->db->set('status', 1);
        $this->db->where('notifikasi_id', $idNotif);
        $this->db->where('pengguna_id', $idPengguna);
        if ($this->db->update('detail_notifikasi')) {
            return true;
        } else {
            return false;
        }
    }
}
