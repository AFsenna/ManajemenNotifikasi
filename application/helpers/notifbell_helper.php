<?php

/**
 * function deleteTokenEXP digunakan untuk menghapus token yang sudah expired (lewat dari 24 jam)
 */
function deleteTokenEXP()
{
    $ci = get_instance();
    $token = $ci->db->get('token')->result_array();
    foreach ($token as $row) {
        if (time() - $row['date'] > (60 * 60 * 24)) {
            $ci->db->delete('token', ['token' => $row['token']]);
        }
    }
}

function checkPengguna($id_pengguna, $id_notifikasi)
{
    $ci = get_instance();
    $result = $ci->db->get_where('detail_notifikasi', [
        'pengguna_id' => $id_pengguna,
        'notifikasi_id' => $id_notifikasi
    ]);
    if ($result->row_array() > 0) {
        return "checked='checked'";
    }
}
