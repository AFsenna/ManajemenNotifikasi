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
        $this->load->model('ReportModel', 'report');
    }

    public function index()
    {
        cekAccessUser();
        $data['title'] = 'Report';
        $data['nama'] = $this->session_data['nama_lengkap'];
        $data['role_id'] = $this->session_data['role_id'];
        $data['aplikasi'] = $this->report->getAplikasi($this->session_data['id_user']);
        $this->template->render('report/index', $data);
    }

    public function exportPDF()
    {
        cekAccessUser();
        $cek = true;
        $this->form_validation->set_rules('tanggalAwal', 'Tanggal awal', 'required');
        $this->form_validation->set_rules('tanggalAkhir', 'Tanggal akhir', 'required');

        $start = strtotime($this->input->post('tanggalAwal'));
        $end = strtotime($this->input->post('tanggalAkhir'));

        if ($start > $end) {
            $cek = false;
        }

        if ($cek == false) {
            $this->session->set_flashdata('message', pesanGagal('tanggal akhir lebih kecil dari tanggal awal!'));
            redirect('report');
        } else {
            if ($this->form_validation->run() == false) {
                $this->index();
            } else {
                $tanggalAwal = $this->input->post('tanggalAwal');
                $tanggalAkhir = $this->input->post('tanggalAkhir');

                $data['aplikasi'] = $this->report->getAplikasi($this->session_data['id_user']);
                $data['namaUser'] = $this->session_data['nama_lengkap'];
                $data['tanggalAwal'] = $tanggalAwal;
                $data['tanggalAkhir'] = $tanggalAkhir;
                $data['penggunaApp'] = $this->report->getPengguna($tanggalAwal, $tanggalAkhir);
                $data['notifikasi'] = $this->report->getNotifikasi($tanggalAwal, $tanggalAkhir);
                $data['penerima'] = $this->report->getPenerima();

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

    public function exportAdmin()
    {
        cekAccessAdmin();
        $data['aplikasi'] = $this->report->getAplikasiAll();
        $data['user'] = $this->report->getUser();

        $options = new Options();
        $options->set('isRemoteEnabled', TRUE);
        $dompdf = new Dompdf($options);
        $body = $this->load->view('report/pdfAdmin', $data, TRUE);
        $dompdf->loadHtml($body);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $dompdf->stream('oke.pdf', array('Attachment' => 0));
    }
}
