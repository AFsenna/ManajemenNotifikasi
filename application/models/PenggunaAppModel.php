<?php

class PenggunaAppModel extends CI_Model
{
    /**
     * Function getPengguna digunakan untuk mengambil data pengguna dalam salah satu aplikasi
     */
    public function getPengguna($idAplikasi)
    {
        $query = $this->db->get_where('pengguna_aplikasi', ['aplikasi_id' => $idAplikasi, 'status_pengguna' => 1]);
        return $query->result_array();
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
     * Function cekNotifPengguna digunakan untuk mengecek apakah pengguna sudah menjadi foreign key 
     * di tabel detail notifikasi
     */
    public function cekNotifPengguna($id)
    {
        return $this->db->get_where('detail_notifikasi', ['pengguna_id' => $id])->row_array();
    }

    /**
     * Function prosesStorePengguna digunakan untuk menyimpan pengguna aplikasi baru ke database
     */
    public function prosesStorePengguna($data)
    {
        $cek = [
            'nama_pengguna' => $data['nama_pengguna'],
            'email_pengguna' => $data['email_pengguna'],
            'notelp_pengguna' => $data['notelp_pengguna'],
            'aplikasi_id' => $data['aplikasi_id']
        ];

        $isiCek = $this->db->get_where('pengguna_aplikasi', $cek)->row_array();

        if ($isiCek) {
            $this->db->set('status_pengguna', 1);
            $this->db->where('id_pengguna', $isiCek['id_pengguna']);
            if ($this->db->update('pengguna_aplikasi')) {
                return true;
            } else {
                return false;
            }
        } else {
            if ($this->db->insert('pengguna_aplikasi', $data)) {
                return true;
            } else {
                return false;
            }
        }
    }

    /**
     * Function updatePengguna digunakan untuk mengubah data pengguna aplikasi yang ada di database
     */
    public function updatePengguna($idPengguna, $set)
    {
        $this->db->where('id_pengguna', $idPengguna);
        if ($this->db->update('pengguna_aplikasi', $set)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function prosesHidden digunakan untuk hidden pengguna dengan cara mengubah status menjadi 0
     */
    public function prosesHidden($id)
    {
        $this->db->set('status_pengguna', 0);
        $this->db->where('id_pengguna', $id);
        if ($this->db->update('pengguna_aplikasi')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Function prosesDeletePengguna digunakan 
     * untuk menghapus pengguna aplikasi di database berdasarkan id yang dipilih
     */
    public function prosesDeletePengguna($id)
    {
        if ($this->db->delete('pengguna_aplikasi', ['id_pengguna' => $id])) {
            return true;
        } else {
            return false;
        }
    }
}
