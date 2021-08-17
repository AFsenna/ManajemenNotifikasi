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
     * saat AuthController dipanggil
     */

    public function __construct()
    {
        parent::__construct();
        $this->load->model('AuthModel');
    }

    /**
     * Function index digunakan untuk menuju tampilan login
     */
    public function index()
    {
        $data['title'] = 'Login';
        $this->load->view('Template/auth_header', $data);
        $this->load->view('Auth/login');
        $this->load->view('Template/auth_footer');
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
            $result = $this->AuthModel->login($username, $password);
            if ($result) {
                foreach ($result as $row) {
                    $data = [
                        'nama_lengkap' => $row->nama_lengkap,
                        'username' => $row->username,
                        'notelp' => $row->notelp,
                        'email' => $row->email,
                        'status' => $row->status,
                        'role_id' => $row->role_id
                    ];
                    $this->session->set_userdata('datauser', $data);
                }
                $session_data = $this->session->userdata('datauser');
                if ($session_data['role_id'] == 1) {
                    redirect('Admin');
                } else if ($session_data['role_id'] == 2) {
                    if ($session_data['status'] == 1) {
                        redirect('User');
                    } else {
                        $this->session->set_flashdata('message', '
                        <div class="alert alert-danger" role="alert">
                            This account has not been activated! please check your email.
                        </div>');
                        redirect('Auth');
                    }
                }
            } else {
                $this->session->set_flashdata('message', '
                    <div class="alert alert-danger" role="alert">
                        Wrong password!
                    </div>');
                redirect('Auth');
            }
        }
    }

    /**
     * Function register digunakan untuk menuju tampilan register
     */
    public function register()
    {
        $data['title'] = 'Register';
        $this->load->view('Template/auth_header', $data);
        $this->load->view('Auth/register');
        $this->load->view('Template/auth_footer');
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
            'required|trim|min_length[6]|matches[password2]',
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
            $this->AuthModel->prosesStore($data);
            $this->AuthModel->storeToken($user_token);
            $this->_sent_Email($token, 'verify', $email);
            $this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
             Congratulation! Your account has been created. Please active your account. 
            </div>');
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
                'smtp_pass' => 'sen@0810',
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

        if ($type == 'verify') {
            $this->email->subject('Account Verification');
            $this->email->message('
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            </head>
                <body style="margin: 0; padding: 0;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                        <tr>
                            <td align="center" bgcolor="#00afb9" style="padding: 40px 0 30px 0;color: #FFFFFF; font-family: Arial, sans-serif; font-size: 24px;">
                                <b>Account Verification</b>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#fdfcdc" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" style="padding: 20px 0 30px 0;color: #293241; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        Terima kasih telah bergabung dengan website Notifbell.</br>
                                        <p>Silahkan klik tombol dibawah ini untuk mengaktifkan akun anda</p>
                                        <a type="button" style="border-radius: 4px;background-color: #0081a7;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;" 
                                         href="' . base_url() . 'Auth/verify?email=' . $email . '&token=' . urlencode($token) . '">Activate</a>
                                        <p><em style="color:#f07167;">*aktivasi ini hanya berlaku 24jam</em></p>
                                    </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#f07167" style="color: #ffffff; font-family: Arial, sans-serif; font-size: 12px;"align="right">
                                <p>Copyright ©Notifbell 2021 </p>
                            </td>
                        </tr>
                    </table>
                </body>
            </html>
            ');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('
            <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
            <html xmlns="http://www.w3.org/1999/xhtml">
            <head>
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
            </head>
                <body style="margin: 0; padding: 0;">
                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600">
                        <tr>
                            <td align="center" bgcolor="#00afb9" style="padding: 40px 0 30px 0;color: #FFFFFF; font-family: Arial, sans-serif; font-size: 24px;">
                                <b>Reset Password</b>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#fdfcdc" style="padding: 40px 30px 40px 30px;">
                            <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td align="center" style="padding: 20px 0 30px 0;color: #293241; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                        <p>Silahkan klik tombol dibawah ini untuk reset password anda!</p>
                                        <a type="button" style="border-radius: 4px;background-color: #0081a7;border: none;color: white;padding: 15px 32px;text-align: center;text-decoration: none;display: inline-block;font-size: 16px;margin: 4px 2px;cursor: pointer;" 
                                         href="' . base_url() . 'Auth/changePassword?email=' . $email . '&token=' . urlencode($token) . '">Reset</a>
                                        <p><em style="color:#f07167;">*aktivasi ini hanya berlaku 24jam</em></p>
                                    </td>
                                </tr>
                            </table>
                            </td>
                        </tr>
                        <tr>
                            <td bgcolor="#f07167" style="color: #ffffff; font-family: Arial, sans-serif; font-size: 12px;"align="right">
                                <p>Copyright ©Notifbell 2021 </p>
                            </td>
                        </tr>
                    </table>
                </body>
            </html>
            ');
        }

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
        $user = $this->AuthModel->getUser($email);

        if ($user) {
            $user_token = $this->AuthModel->getToken($token);
            if ($user_token) {
                if (time() - $user_token['date'] < (60 * 60 * 24)) {
                    $this->AuthModel->UpdateStatus($email);
                    $this->AuthModel->deleteToken($email);
                    $this->session->set_flashdata('message', '
                    <div class="alert alert-success" role="alert">
                     ' . $email . ' has been activated! Please login.
                    </div>');
                    redirect('Auth');
                } else {
                    $this->AuthModel->deleteUser($email);
                    $this->AuthModel->deleteToken($email);
                    $this->session->set_flashdata('message', '
                    <div class="alert alert-danger" role="alert">
                     Account activation failed Token expired! Please register again
                    </div>');
                    redirect('Auth/register');
                }
            } else {
                $this->session->set_flashdata('message', '
                <div class="alert alert-danger" role="alert">
                 Account activation failed! Wrong token.
                </div>');
                redirect('Auth');
            }
        } else {
            $this->session->set_flashdata('message', '
            <div class="alert alert-danger" role="alert">
             Account activation failed! Wrong email.
            </div>');
            redirect('Auth/register');
        }
    }

    /**
     * Function forgotpassword digunakan untuk menuju tampilan lupa password
     */
    public function forgotpassword()
    {
        $data['title'] = 'Forgot Password';
        $this->load->view('Template/auth_header', $data);
        $this->load->view('Auth/forgotpassword');
        $this->load->view('Template/auth_footer');
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
            $user = $this->AuthModel->cekUser($email);

            if ($user) {
                $token = rand(10000, 99999);
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date' => time()
                ];

                $this->AuthModel->storeToken($user_token);

                $this->_sent_Email($token, 'forgot', $email);

                $this->session->set_flashdata('message', '
                <div class="alert alert-success" role="alert">
                 Please check your email to reset your password!
                </div>');
                redirect('Auth');
            } else {
                $this->session->set_flashdata('message', '
                <div class="alert alert-danger" role="alert">
                 Email is not registered or activated!
                </div>');
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
        $user = $this->AuthModel->getToken2($email);

        if ($user) {
            $user_token = $this->AuthModel->getToken($token);

            if ($user_token) {
                if (time() - $user_token['date_created'] < (60 * 60 * 24)) {
                    $this->session->set_userdata('reset_email', $email);
                    $data['title'] = 'Change Password';
                    $this->load->view('Template/auth_header', $data);
                    $this->load->view('Auth/changepassword');
                    $this->load->view('Template/auth_footer');
                }
            } else {
                $this->session->set_flashdata('message', '
                <div class="alert alert-danger" role="alert">
                 Reset password failed! Wrong token.
                </div>');
                redirect('Auth');
            }
        } else {
            $this->session->set_flashdata('message', '
                <div class="alert alert-danger" role="alert">
                 Reset password failed! Wrong email.
                </div>');
            redirect('Auth');
        }
    }

    /**
     * Function resetPassword digunakan untuk menyimpan password baru
     */
    public function resetPassword()
    {
    }

    /**
     * function logout digunakan untuk logout dan destroy session
     */

    public function logout()
    {
        $this->session->unset_userdata('datauser');

        $this->session->set_flashdata('message', '
            <div class="alert alert-success" role="alert">
                You have been logged out!
            </div>');
        $this->index();
    }
}
