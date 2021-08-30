<?php

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * defined('BASEPATH') or exit('No direct script access allowed');
 * Berfungsi untuk memproteksi agar script yang kita buat tidak dapat diakses secara langsung 
 * dan harus melalui www.namaweb.com/controller
 */
defined('BASEPATH') or exit('No direct script access allowed');

class Report extends CI_Controller
{
    protected $session_data;
    /**
     * Function __construct() merupakan fungsi yang di eksekusi pertama kali 
     * saat PenggunaAplikasi Controller dipanggil
     */
    public function __construct()
    {
        parent::__construct();

        $this->session_data = $this->session->userdata('datauser');
        $this->load->model('PenggunaAppModel', 'pengguna');
        $this->load->model('AplikasiModel', 'apk');
        $this->load->model('NotifikasiModel', 'notif');

        cekAccessUser();
    }

    public function index()
    {
        $data['title'] = 'Report';
        $data['nama'] = $this->session_data['nama_lengkap'];
        $data['role_id'] = $this->session_data['role_id'];
        $data['aplikasi'] = $this->apk->myAplikasi($this->session_data['id_user']);
        $this->template->render('report/index', $data);
    }

    public function exportPDF()
    {
        $this->form_validation->set_rules('tanggalAwal', 'Tanggal awal', 'required');
        $this->form_validation->set_rules('tanggalAkhir', 'Tanggal akhir', 'required');

        $data['aplikasi'] = 'halo';
        $data['penggunaApp'] = 'tes';
        $data['notifikasi'] = 'tes';

        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $options = new Options();
            $options->set('isRemoteEnabled', TRUE);
            $dompdf = new Dompdf($options);
            $body = $this->load->view('report/tampilanPDF', $data, TRUE);
            $dompdf->loadHtml($body);
            $dompdf->setPaper('A4', 'portrait');
            $dompdf->render();
            $dompdf->stream('oke.pdf', array('Attachment' => 0));
        }
    }
}
