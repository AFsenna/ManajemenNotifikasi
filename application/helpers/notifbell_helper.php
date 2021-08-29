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

/**
 * function checkpengguna digunakan untuk mendapatkan data penerima yang sudah di checklist
 */
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

/**
 * Function cekAccessUser untuk mengecek apakah user sudah login saat membuka aplikasi
 * dan mengecek apakah user memiliki role sebagai 'user'
 */
function cekAccessUser()
{
    $ci = get_instance();
    $session_data = $ci->session->userdata('datauser');
    if (!$ci->session->userdata('datauser')) {
        redirect('Auth');
    } else if ($session_data['role_id'] == 1) {
        redirect('Auth/blocked');
    }
}

/**
 * Function cekAccessAdmin untuk mengecek apakah user sudah login saat membuka aplikasi
 * dan mengecek apakah user memiliki role sebagai 'admin'
 */
function cekAccessAdmin()
{
    $ci = get_instance();
    $session_data = $ci->session->userdata('datauser');
    if (!$session_data) {
        redirect('Auth');
    } else if ($session_data['role_id'] == 2) {
        redirect('Auth/blocked');
    }
}

function defaultPage()
{
    $ci = get_instance();
    $session_data = $ci->session->userdata('datauser');
    if ($session_data['role_id'] == 1) {
        redirect('admin');
    } else if ($session_data['role_id'] == 2) {
        redirect('user');
    }
}

/**
 * Function ini digunakan untuk menampilkan alert sukses
 */
function pesanSukses($data)
{
    return '<div class="alert alert-success" role="alert">' . $data . '</div>';
}

/**
 * Function ini digunakan untuk menampilkan alert danger
 */
function pesanGagal($data)
{
    return '<div class="alert alert-danger" role="alert">' . $data . '</div>';
}

/**
 * Function dd digunakan untuk var dump data / mengecek data
 */
function dd($data)
{
    echo "<pre>" . var_export($data) . "</pre>";
    die();
}
