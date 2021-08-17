<?php

/**
 * function deleteTokenEXP digunakan untuk menghapus token yang sudah expired (lewat dari 24 jam)
 */
function deleteTokenEXP()
{
    $ci = get_instance();
    $token = $ci->db->get('token')->result_array();
    foreach ($token as $row) {
        if (time() - $row['date'] < (60 * 60 * 24)) {
            $ci->db->delete('token', ['token' => $row['token']]);
        }
    }
}
