<?php

/**
 * Pada user Apabila status = 1 maka user sudah mengaktifkan akunnya melalui token yang sudah dikirim ke email
 * apabila status = 0 maka user belum mengaktifkan akunnya
 */

/**
 * defined('BASEPATH') or exit('No direct script access allowed');
 * Berfungsi untuk memproteksi agar script yang kita buat tidak dapat diakses secara langsung 
 * contoh : untuk mengakses harus melalui www.namaweb.com/namacontroller
 */

defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    /**
     * Function __construct() merupakan fungsi yang di eksekusi pertama kali 
     * saat Auth Controller dipanggil
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('AuthModel', 'auth');
        $this->load->model('TokenModel', 'token');

        deleteTokenEXP();
    }

    /**
     * Function index digunakan untuk menuju tampilan login
     */
    public function index()
    {
        defaultPage();
        $data['title'] = 'Login';

        $this->template->renderAuth('Auth/login', $data);
    }

    /**
     * Function authUser digunakan untuk authentication user
     */
    public function authUser()
    {
        $this->form_validation->set_rules('username', 'Username', 'required|trim');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $this->index();
        } else {
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $user = $this->auth->login($username);

            if ($user) {
                if ($user['status'] == 1) {
                    $data = [
                        'nama_lengkap' => ucwords($user['nama_lengkap']),
                        'username' => ucfirst($user['username']),
                        'notelp' => $user['notelp'],
                        'email' => $user['email'],
                        'status' => $user['status'],
                        'role_id' => $user['role_id'],
                        'id_user' => $user['id_user'],
                        'password' => $user['password']
                    ];

                    $this->session->set_userdata('datauser', $data);

                    if (password_verify($password, $user['password'])) {
                        if ($user['role_id'] == 1) {
                            redirect('Admin');
                        } else if ($user['role_id'] == 2) {
                            redirect('User');
                        }
                    } else {
                        $this->session->set_flashdata('message', pesanGagal('Password Salah!'));
                        redirect('Auth');
                    }
                } else {
                    $this->session->set_flashdata('message', pesanGagal('Akun belum di aktifkan! silahkan cek email anda.'));
                    redirect('Auth');
                }
            } else {
                $this->session->set_flashdata('message', pesanGagal('Akun belum terdaftar!'));
                redirect('Auth');
            }
        }
    }

    /**
     * Function register digunakan untuk menuju tampilan register
     */
    public function register()
    {
        defaultPage();
        $data['title'] = 'Register';

        $this->template->renderAuth('Auth/register', $data);
    }

    /**
     * Function storeUser digunakan untuk menyimpan user baru ke database
     * dan mengirim token ke email user untuk mengaktifkan akunnya
     */
    public function storeUser()
    {
        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('phone', 'phone', 'required|trim');
        $this->form_validation->set_rules(
            'username',
            'Username',
            'required|trim|is_unique[user.username]',
            [
                'is_unique' => 'This username has already registered!'
            ]
        );
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[user.email]', [
            'is_unique' => 'This email has already registered!'
        ]);
        $this->form_validation->set_rules(
            'password1',
            'Password',
            'required|trim|min_length[3]|max_length[6]|matches[password2]',
            [
                'matches' => 'Password Dont Match!',
                'min_length' => 'Password Too Short!'
            ]
        );
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $this->register();
        } else {
            $name = htmlspecialchars($this->input->post('name', true));
            $email = htmlspecialchars($this->input->post('email', true));
            $phone = $this->input->post('phone', true);
            $username = $this->input->post('username', true);
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $data = [
                'nama_lengkap' => $name,
                'email' => $email,
                'notelp' => $phone,
                'username' => $username,
                'password' => $password,
                'role_id' => 2,
                'status' => 0
            ];
            $token = rand(10000, 99999);
            $user_token = [
                'email' => $email,
                'token' => $token,
                'date' => time()
            ];

            if ($this->auth->prosesStore($data)) {
                if ($this->token->storeToken($user_token)) {
                    $this->_sent_Email($token, 'verify', $email);
                    $this->session->set_flashdata('message', pesanGagal('Akun telah didaftarkan. Silahkan cek email anda untuk aktivasi!'));
                } else {
                    $this->session->set_flashdata('message', pesanGagal('Proses penyimpanan token gagal!'));
                }
            } else {
                $this->session->set_flashdata('message', pesanGagal('Gagal mendaftarkan akun!'));
            }
            redirect('Auth');
        }
    }

    /**
     * Functin _sent_Email digunakan untuk mengirim email ke user ketika proses Auth
     */
    private function _sent_Email($token, $type, $email)
    {
        $this->load->library('email');

        $config =
            [
                'smtp_host' => 'smtp.gmail.com',
                'smtp_port' => '587',
                'smtp_user' => 'qsenweb@gmail.com',
                '_smtp_auth' => TRUE,
                'smtp_pass' => 'vey@1234',
                'smtp_crypto' => 'tls',
                'protocol' => 'smtp',
                'mailtype' => 'html',
                'send_multipart' => FALSE,
                'charset' => 'utf-8',
                'wordwrap' => TRUE
            ];
        $this->email->initialize($config);

        $this->email->set_newline("\r\n");
        $this->email->from('qsenweb@gmail.com', 'Admin Notifbell');
        $this->email->to($this->input->post('email'));
        $data['email'] = $email;
        $data['token'] = urlencode($token);
        $data['type'] = $type;
        $body = $this->load->view('Auth/tampilanEmail', $data, TRUE);
        if ($type == 'verify') {
            $this->email->subject('Account Verification');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');
        }
        $this->email->message($body);

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die();
        }
    }

    /**
     * function verify digunakan untuk mengaktifkan akun user yang sudah mendaftar
     * (mengubah status user dari 0 menjadi 1)
     */

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $user = $this->auth->getUser($email);

        if ($user) {
            $user_token = $this->token->getToken($token);
            if ($user_token) {
                if (time() - $user_token['date'] < (60 * 60 * 24)) {
                    if ($this->auth->UpdateStatus($email)) {
                        if ($this->token->deleteToken($email)) {
                            $this->session->set_flashdata('message', pesanSukses($email . ' berhasil diaktifkan! Silahkan login.'));
                        } else {
                            $this->session->set_flashdata('message', pesanGagal('Token milik user dengan email : ' . $email . ' gagal dihapus!'));
                        }
                    } else {
                        $this->session->set_flashdata('message', pesanGagal($email . ' Gagal update status akun!'));
                    }
                    redirect('Auth');
                } else {
                    if ($this->auth->deleteUser($email)) {
                        if ($this->token->deleteToken($email)) {
                            $this->session->set_flashdata('message', pesanGagal('Aktivasi gagal! Silahkan daftar akun kembali!'));
                        } else {
                            $this->session->set_flashdata('message', pesanGagal('Token milik user dengan email : ' . $email . ' gagal dihapus!'));
                        }
                    } else {
                        $this->session->set_flashdata('message', pesanGagal('User dengan email : ' . $email . ' gagal dihapus!'));
                    }
                    redirect('Auth/register');
                }
            } else {
                $this->session->set_flashdata('message', pesanGagal('Aktivasi gagal! Token salah!'));
                redirect('Auth');
            }
        } else {
            $this->session->set_flashdata('message', pesanGagal('Aktivasi gagal! Email salah!'));
            redirect('Auth/register');
        }
    }

    /**
     * Function forgotpassword digunakan untuk menuju tampilan lupa password
     */
    public function forgotpassword()
    {
        defaultPage();
        $data['title'] = 'Forgot Password';

        $this->template->renderAuth('Auth/forgotpassword', $data);
    }

    /**
     * Function restorePassword digunakan untuk mengirimkan email ke user untuk mengubah passwordnya
     */
    public function restorePassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim');
        if ($this->form_validation->run() == false) {
            $this->forgotpassword();
        } else {
            $email = $this->input->post('email');
            $user = $this->auth->cekUser($email);

            if ($user) {
                $token = rand(10000, 99999);
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date' => time()
                ];

                if ($this->token->storeToken($user_token)) {
                    $this->_sent_Email($token, 'forgot', $email);
                    $this->session->set_flashdata('message', pesanSukses('Silahkan cek email anda untuk reset password!'));
                } else {
                    $this->session->set_flashdata('message', pesanGagal('Gagal reset password!'));
                }

                redirect('Auth');
            } else {
                $this->session->set_flashdata('message', pesanGagal('Email tidak terdaftar atau belum di aktivasi!'));
                redirect('Auth/forgotpassword');
            }
        }
    }

    /**
     * Function changePassword digunakan untuk menuju tampilan ganti password
     */
    public function changePassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');
        $user = $this->token->getTokenbytk($token);

        if ($user) {
            $user_token = $this->token->getTokenbyem($email);

            if ($user_token) {
                if (time() - $user_token['date'] < (60 * 60 * 24)) {
                    $this->session->set_userdata('reset_email', $email);
                    if ($this->token->deleteToken($token)) {
                        $data['title'] = 'Change Password';
                        $this->template->renderAuth('Auth/changepassword', $data);
                    } else {
                        $this->session->set_flashdata('message', pesanGagal('Gagal delete token!'));
                        redirect('Auth');
                    }
                }
            } else {
                $this->session->set_flashdata('message', pesanGagal('Gagal reset password! Email salah.'));
                redirect('Auth');
            }
        } else {
            $this->session->set_flashdata('message', pesanGagal('Reset password gagal! Token salah.'));
            redirect('Auth');
        }
    }

    /**
     * Function resetPassword digunakan untuk menyimpan password baru
     */
    public function resetPassword()
    {
        $this->form_validation->set_rules(
            'password1',
            'Password',
            'required|trim|min_length[3]|max_length[6]|matches[password2]',
            [
                'matches' => 'Password Dont Match!',
                'min_length' => 'Password Too Short!'
            ]
        );
        $this->form_validation->set_rules('password2', 'Password', 'required|trim|matches[password1]');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'Change Password';
            $this->template->renderAuth('Auth/changepassword', $data);
        } else {
            $password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            if ($this->auth->updatePassword($password, $email)) {
                $this->session->unset_userdata('reset_email');
                $this->session->set_flashdata('message', pesanSukses('Password berhasil diubah! silahkan login'));
            } else {
                $this->session->set_flashdata('message', pesanGagal('Gagal update password!'));
            }

            redirect('Auth');
        }
    }

    /**
     * function logout digunakan untuk logout dan destroy session
     */
    public function logout()
    {
        $this->session->unset_userdata('datauser');
        $this->session->set_flashdata('message', pesanSukses('Berhasil logout!'));
        $this->index();
    }

    /**
     * Function blocked digunakan untuk menampilkan halaman blocked access
     */
    public function blocked()
    {
        $session_data = $this->session->userdata('datauser');
        $data['role'] = $session_data['role_id'];

        $this->load->view('Auth/blocked', $data);
    }
}
