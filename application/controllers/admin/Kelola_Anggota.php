<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *  File Name             : Kelola_Anggota.php
 *  File Type             : Controller
 *  File Package          : CI_Controller
 ** * * * * * * * * * * * * * * * * * **
 *  Author                : Rizky Ardiansyah
 *  Date Created          : 04/08/2022
 *  Quots of the code     : 'Hanya seorang yang hobi berbicara dengan komputer.'
 */
class Kelola_Anggota extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        if (!logged_in()) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Anda tidak mempunyai akses, silahkan login!</div>');
            redirect('auth/login', 'refresh');
        };
        $this->load->model('M_users', 'users');
    }

    public function index()
    {
        $data['title'] = 'PORTAL SPSI';
        $data['page'] = 'Admin';
        $data['subpage'] = 'Kelola Anggota';
        $data['content'] = 'page/admin/v_kelola_anggota';
        $this->load->view('template', $data);
    }

    public function get_data()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            if (isset($data_post['id'])) {
                $resData = $this->users->get_data(['id' => $data_post['id']])->row_array();
            } else {
                $resData = $this->users->get_data()->result_array();
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

    public function delete_data()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            $delete = $this->users->deleteData('users', ['id' => $data_post['id']]);
            if (!$delete) {
                $this->users->deleteData('users_groups', ['id' => $data_post['id']]);
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
                    'message' => 'Data berhasil dihapus.',
                    'data' => $delete
                ];
            }
            echo json_encode($data);
        } else {
            show_404();
        }
    }

    public function update_status_aktiv()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            $resData = $this->users->updateData(['active' => $data_post['data_update']], ['id' => $data_post['id']]);
            $message = '';
            if ($data_post['data_update'] === '1') {
                $message = 'Aktivasi Berhasil!';
            } else {
                $message = 'Anggota Berhasil Di Nonaktifkan!';
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
                    'message' => $message,
                    'data' => $resData
                ];
            }
            echo json_encode($data);
        } else {
            show_404();
        }
    }
}
