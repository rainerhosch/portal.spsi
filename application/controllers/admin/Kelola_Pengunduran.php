<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *  File Name             : Kelola_Pengunduran.php
 *  File Type             : Controller
 *  File Package          : CI_Controller
 ** * * * * * * * * * * * * * * * * * **
 *  Author                : Rizky Ardiansyah
 *  Date Created          : 05/08/2022
 *  Quots of the code     : 'Hanya seorang yang hobi berbicara dengan komputer.'
 */
class Kelola_Pengunduran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        if (!logged_in()) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Anda tidak mempunyai akses, silahkan login!</div>');
            redirect('auth/login', 'refresh');
        };
        $this->load->model('M_pengundurandiri', 'pengundurandiri');
        $this->load->model('M_users', 'users');
    }

    public function index()
    {
        $data['title'] = 'PORTAL SPSI';
        $data['page'] = 'Admin';
        $data['subpage'] = 'Kelola Pengunduran';
        $data['content'] = 'page/admin/v_kelola_pengunduran';
        $this->load->view('template', $data);
    }

    public function get_data()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            if (isset($data_post['id'])) {
                $resData = $this->pengundurandiri->get_data(['id' => $data_post['id']])->row_array();
            } else {
                $resData = $this->pengundurandiri->get_data()->result_array();
                foreach ($resData as $i => $val) {
                    $data_anggota = $this->users->get_data(['id' => $val['user_id']])->row_array();
                    $resData[$i]['nama_lengkap'] = $data_anggota['first_name'] . ' ' . $data_anggota['last_name'];
                    $resData[$i]['email'] = $data_anggota['email'];
                    $resData[$i]['phone'] = $data_anggota['phone'];
                    $resData[$i]['departemen'] = $data_anggota['departemen'];
                }
            }
            if (!$resData) {
                $data = [
                    'status' => false,
                    'code' => 500,
                    'icon' => 'error',
                    'message' => 'Koneksi Server Error!',
                    'data' => null
                ];
            } else {
                $data = [
                    'status' => true,
                    'code' => 200,
                    'icon' => 'success',
                    'message' => 'Data Found!.',
                    'data' => $resData
                ];
            }
            echo json_encode($data);
        } else {
            show_404();
        }
    }

    public function approve()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            $id_pengunduran = $data_post['id'];
            $id_user = $data_post['user_id'];
            $update = $this->pengundurandiri->update_data(['status' => 1], ['id' => $id_pengunduran]);
            if (!$update) {
                $data = [
                    'status' => false,
                    'code' => 500,
                    'icon' => 'error',
                    'message' => 'Koneksi Server Error!',
                    'data' => null
                ];
            } else {
                $this->users->updateData(['active' => 2], ['id' => $id_user]);
                $data = [
                    'status' => true,
                    'code' => 200,
                    'icon' => 'success',
                    'message' => 'Data Found!.',
                    'data' => null
                ];
            }
            echo json_encode($data);
        } else {
            show_404();
        }
    }
}
