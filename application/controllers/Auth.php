<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *  File Name             : Auth.php
 *  File Type             : Controller
 *  File Package          : CI_Controller
 ** * * * * * * * * * * * * * * * * * **
 *  Author                : Rizky Ardiansyah
 *  Date Created          : 02/08/2022
 *  Quots of the code     : 'Hanya seorang yang hobi berbicara dengan komputer.'
 */
class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        $this->load->model('M_users', 'users');
        $this->load->model('Auth_model', 'authmodel');
    }

    public function index()
    {
        if ($this->input->post()) {
            $data_post = $this->input->post();
            $data_user = $this->users->get_data(['email' => $data_post['email']])->row_array();
            $data['login_attempts'] = [
                'ip_address' => get_client_ip(),
                'login' => $data_user['email'],
                'time' => strtotime(date("Y-m-d H:i:s"))
            ];
            if ($data_user != null) {
                if ($data_user['active'] === '1') {
                    $login_attempts = check_login_attempts($data_user['email']);
                    $jml_attempts = count($login_attempts);
                    if ($jml_attempts >= 3) {
                        $last_attempts_time = $login_attempts[1]['time'];
                        // $time_now = strtotime("2022-08-05 10:50:01");
                        // var_dump($time_now);
                        // die;
                        $time_now = strtotime(date("Y-m-d H:i:s"));
                        $seconds   = $time_now - $last_attempts_time;
                        $months = floor($seconds / (3600 * 24 * 30));
                        $day = floor($seconds / (3600 * 24));
                        $hours = floor($seconds / 3600);
                        $mins = floor(($seconds - ($hours * 3600)) / 60);
                        $secs = floor($seconds % 60);
                        // var_dump(date("Y-m-d H:i:s", $last_attempts_time));
                        // echo '<br>';
                        // var_dump($day);
                        // echo '<br>';
                        // var_dump($hours);
                        // echo '<br>';
                        // var_dump($mins);
                        // die;
                        if ($day > 0 || $hours > 0 || $mins > 30) {
                            if ($data_user['password'] == md5($data_post['password'])) {
                                if ($login_attempts > 0) {
                                    remove_data_login_attempts($data_user['email']);
                                }
                                save_data_session($data_user);
                                redirect('dashboard', 'refresh');
                            }
                        } else {
                            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">Melebihi batas percobaan login, silahkan tunggu beberapa saat.</div>');
                            redirect('auth/login', 'refresh');
                        }
                    } else {
                        if ($data_user['password'] == md5($data_post['password'])) {
                            if ($login_attempts > 0) {
                                remove_data_login_attempts($data_user['email']);
                            }
                            save_data_session($data_user);
                            redirect('dashboard', 'refresh');
                        } else {
                            insert_login_attempts($data['login_attempts']);
                            $this->session->set_flashdata('message', '<div class="alert alert-warning text-center">Password salah!. Silahkan coba kembali.</div>');
                            redirect('auth/login', 'refresh');
                        }
                    }
                } else {
                    $this->session->set_flashdata('message', '<div class="alert alert-warning text-center"><p>Akun tidak aktif, silahkan hubungi Admin.</p></div>');
                    redirect('auth/login', 'refresh');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger text-center"><p>Data login tidak ditemukan!. Silahkan coba kembali.</p></div>');
                redirect('auth/login', 'refresh');
            }
        }

        // echo logged_in();
        if (!logged_in()) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Anda tidak mempunyai akses, silahkan login!</div>');
            redirect('auth/login', 'refresh');
        } else {
            login_checker();
        }
    }

    public function login()
    {
        // code here...
        $data['title'] = 'PORTAL SPSI';
        $data['page'] = 'Auth';
        $data['subpage'] = 'Login';
        $data['content'] = 'auth/v_login';
        $this->load->view('template', $data);
    }

    public function register()
    {
        $data['title'] = 'PORTAL SPSI';
        $data['page'] = 'Auth';
        $data['subpage'] = 'Register';
        $data['content'] = 'auth/v_register';
        $this->load->view('template', $data);
    }

    public function register_new_user()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            $active = 0;
            if (logged_in()) {
                $active = 1;
            }
            $data_insert = [
                'ip_address' => get_client_ip(),
                'username' => $data_post['first_name'],
                'password' => md5($data_post['password']),
                'email' => $data_post['email'],
                'created_on' => strtotime(date('H:i:s')),
                'active' => $active,
                'first_name' => $data_post['first_name'],
                'last_name' => $data_post['last_name'],
                'departemen' => $data_post['departemen'],
                'phone' => $data_post['phone'],
                'user_img' => 'default_profile.svg'
            ];
            $isert_user = $this->users->add_data_anggota($data_insert);
            if ($isert_user) {
                $insert_userGroup = [
                    'user_id' => $isert_user,
                    'group_id' => 2
                ];
                $this->users->add_users_groups($insert_userGroup);
                $data = [
                    'status' => true,
                    'code' => 200,
                    'icon' => 'success',
                    'message' => 'Success add new user.',
                    'data' => null
                ];
            } else {
                $data = [
                    'status' => false,
                    'code' => 500,
                    'icon' => 'error',
                    'message' => 'Gagal insert data.',
                    'data' => null
                ];
            }
            echo json_encode($data);
        } else {
            show_404();
        }
    }

    public function reset_password()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            $data_update = [
                'password' => md5('user1234'),
            ];
            $update_user = $this->users->updateData($data_update, ['id' => $data_post['id']]);
            if ($update_user) {
                $data = [
                    'status' => true,
                    'code' => 200,
                    'icon' => 'success',
                    'message' => 'Success update data.',
                    'data' => null
                ];
            } else {
                $data = [
                    'status' => false,
                    'code' => 500,
                    'icon' => 'error',
                    'message' => 'Gagal update data.',
                    'data' => null
                ];
            }
            echo json_encode($data);
        } else {
            show_404();
        }
    }

    public function logout()
    {

        $this->session->unset_userdata('is_login');
        $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Berhasil Logout!</div>');
        redirect('auth/login', 'refresh');
    }
}
