<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

/**
 * Pada pengunaAplikasi status 0 untuk hidden dan 1 apabila aktif
 */

/**
 * defined('BASEPATH') or exit('No direct script access allowed');
 * Berfungsi untuk memproteksi agar script yang kita buat tidak dapat diakses secara langsung 
 * dan harus melalui www.namaweb.com/controller
 */
defined('BASEPATH') or exit('No direct script access allowed');

class PenggunaAplikasi extends CI_Controller
{
    /**
     * Function __construct() merupakan fungsi yang di eksekusi pertama kali 
     * saat PenggunaAplikasi Controller dipanggil
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('PenggunaAppModel', 'pengguna');
        $this->load->model('AplikasiModel', 'apk');

        cekAccessUser();
    }

    /**
     * Function index digunakan untuk menuju tampilan pengguna
     */
    public function index($namaAplikasi, $idAplikasi)
    {
        $session_data = $this->session->userdata('datauser');

        $data['title'] = "Pengguna Aplikasi $namaAplikasi";
        $data['namaAplikasi'] = $namaAplikasi;
        $data['id_aplikasi'] = $idAplikasi;
        $data['role_id'] = $session_data['role_id'];
        $data['nama'] = $session_data['nama_lengkap'];
        $data['aplikasi'] = $this->apk->myAplikasi($session_data['id_user']);
        $data['pengguna'] = $this->pengguna->getPengguna($idAplikasi);

        $this->template->render('penggunaAplikasi/index', $data);
    }

    /**
     * Function storePengguna digunakan untuk menyimpan data pengguna aplikasi
     */
    public function storePengguna($namaAplikasi, $idAplikasi)
    {
        $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() == false) {
            $this->index($namaAplikasi, $idAplikasi);
        } else {
            $nama = $this->input->post('nama');
            $phone = $this->input->post('phone');
            $email = $this->input->post('email');
            $tanggal = date('Y-m-d');
            $data = [
                'nama_pengguna' => $nama,
                'notelp_pengguna' => $phone,
                'email_pengguna' => $email,
                'aplikasi_id' => $idAplikasi,
                'status_pengguna' => 1,
                'tanggal_dibuat' => $tanggal
            ];

            if ($this->pengguna->prosesStorePengguna($data)) {
                $this->session->set_flashdata('message', pesanSukses('Pengguna aplikasi berhasil ditambahkan!'));
            } else {
                $this->session->set_flashdata('message', pesanGagal('Pengguna aplikasi gagal ditambahkan!'));
            }

            redirect('penggunaAplikasi/index/' . $namaAplikasi . '/' . $idAplikasi);
        }
    }

    /**
     * Function editPengguna digunakan untuk mengubah data pengguna aplikasi yang sudah ada
     */
    public function editPengguna($namaAplikasi, $idAplikasi, $idPengguna)
    {
        $this->form_validation->set_rules('nama', 'Name', 'required|trim');
        $this->form_validation->set_rules('phone', 'Phone', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');

        if ($this->form_validation->run() == false) {
            $this->index($namaAplikasi, $idAplikasi);
        } else {
            $nama = $this->input->post('nama');
            $phone = $this->input->post('phone');
            $email = $this->input->post('email');
            $tanggal = date('Y-m-d');
            $set = [
                'nama_pengguna' => $nama,
                'notelp_pengguna' => $phone,
                'email_pengguna' => $email,
                'tanggal_dibuat' => $tanggal
            ];

            if ($this->pengguna->updatePengguna($idPengguna, $set)) {
                $this->session->set_flashdata('message', pesanSukses('Pengguna aplikasi berhasil diupdate!'));
            } else {
                $this->session->set_flashdata('message', pesanSukses('Pengguna aplikasi gagal diupdate!'));
            }
            redirect('penggunaAplikasi/index/' . $namaAplikasi . '/' . $idAplikasi);
        }
    }

    /**
     * Function deletePengguna digunakan menghapus aplikasi yang dipilih
     * dan dengan syarat belum ada pengguna yang terdaftar
     */

    public function deletePengguna($namaAplikasi, $idAplikasi, $id)
    {
        $cek = $this->pengguna->cekNotifPengguna($id);

        if ($cek) {
            $this->pengguna->prosesHidden($id);
            $this->session->set_flashdata('message', pesanSukses('Data pengguna aplikasi berhasil dihapus!'));
        } else {
            if ($this->pengguna->prosesDeletePengguna($id)) {
                $this->session->set_flashdata('message', pesanSukses('Data pengguna aplikasi berhasil dihapus!'));
            } else {
                $this->session->set_flashdata('message', pesanSukses('Data pengguna aplikasi gagal dihapus!'));
            }
        }

        redirect('penggunaAplikasi/index/' . $namaAplikasi . '/' . $idAplikasi);
    }

    /**
     * Function storeExcel digunakan untuk menyimpan data dari impor excel
     */
    public function storeExcel($namaAplikasi, $idAplikasi)
    {
        $this->form_validation->set_rules('noIsi', 'Kolom isi data', 'required|trim');
        $this->form_validation->set_rules('noNama', 'Kolom nama', 'required|trim');
        $this->form_validation->set_rules('noHP', 'Kolom nomor telepon', 'required|trim');
        $this->form_validation->set_rules('noEmail', 'Kolom email', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->index($namaAplikasi, $idAplikasi);
        } else {
            $KolomIsi = $this->input->post('noIsi') - 1;
            $KolomNama = $this->input->post('noNama') - 1;
            $KolomHp = $this->input->post('noHP') - 1;
            $KolomEmail = $this->input->post('noEmail') - 1;

            /**
             * menuliskan beberapa format file excel, 
             * yang nantinya akan digunakan sebagai validasi format file yang didukung, 
             * sebelum proses import data kedatabase dilakukan
             */
            $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

            /**
             * memeriksa apakah memang ada file yang kita pilih saat proses import dilakukan, 
             * serta format tipe file sesuai dengan yang telah kita tentukan pada array $file_mimes
             */
            if (isset($_FILES['berkas']['name']) && in_array($_FILES['berkas']['type'], $file_mimes)) {
                /**
                 * lakukan explode pada nama file excel, untuk mengetahui extention file yang kita pilih.
                 */
                $arr_file = explode('.', $_FILES['berkas']['name']);
                $extension = end($arr_file);

                /**
                 * lakukan pengecekan jika file extention adalah csv maka akan dibuat object dengan class reader csv, 
                 * tetapi jika tidak dibuatkan object dengan class reader xlsx
                 */
                if ('csv' == $extension) {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
                } else {
                    $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
                }

                /**
                 * load file excel yang kita upload dan disimpan didalam variabel $spreadsheet
                 */
                $spreadsheet = $reader->load($_FILES['berkas']['tmp_name']);

                /**
                 * membuat variabel $sheetData yang digunakan untuk menyimpan array, hasil konversi isi dari file excel, menjadi bentuk array.
                 */
                $sheetData = $spreadsheet->getActiveSheet()->toArray();

                /**
                 * kita lakukan perulangan dengan menggunakan for,
                 * $i = kolomIsi-1 dikarenakan index array hasil konversi file excel dimulai dari index ke 0
                 */
                // dd($_FILES['berkas']['tmp_name']);
                for ($i = $KolomIsi; $i < count($sheetData); $i++) {
                    // echo $i;
                    $nama = $sheetData[$i][$KolomNama];
                    $nohp = $sheetData[$i][$KolomHp];
                    $email = $sheetData[$i][$KolomEmail];
                    $tanggal = date('Y-m-d');

                    if ($nama != NULL && $nohp != NULL && $email != NULL) {
                        $data = array(
                            'nama_pengguna' => $nama,
                            'notelp_pengguna' => $nohp,
                            'email_pengguna' => $email,
                            'aplikasi_id' => $idAplikasi,
                            'status_pengguna' => 1,
                            'tanggal_dibuat' => $tanggal
                        );

                        if ($this->pengguna->prosesStorePengguna($data)) {
                            $this->session->set_flashdata('message', pesanSukses('Pengguna aplikasi berhasil ditambahkan!'));
                        } else {
                            $this->session->set_flashdata('message', pesanGagal('Pengguna aplikasi gagal ditambahkan!'));
                        }
                    }
                }
                redirect('penggunaAplikasi/index/' . $namaAplikasi . '/' . $idAplikasi);
            }
        }
    }
}
