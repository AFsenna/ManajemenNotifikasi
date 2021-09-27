<?php

/**
 * defined('BASEPATH') or exit('No direct script access allowed');
 * Berfungsi untuk memproteksi agar script yang kita buat tidak dapat diakses secara langsung 
 * dan harus melalui www.namaweb.com/controller
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Media extends CI_Controller
{
    protected $session_data;

    /**
     * Function __construct() merupakan fungsi yang di eksekusi pertama kali saat
     * Admin Controller dipanggil/digunakan
     */
    public function __construct()
    {
        parent::__construct();

        $this->session_data = $this->session->userdata('datauser');
        $this->load->model('MediaModel', 'media');
        $this->load->model('AplikasiModel', 'apk');

        cekAccessAdmin();
    }

    public function index()
    {
        $data['title'] = 'Media';
        $data['role_id'] = $this->session_data['role_id'];
        $data['nama'] = $this->session_data['nama_lengkap'];
        $data['media'] = $this->media->getMedia();

        $this->template->render('media/index', $data);
    }
}
