<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *  File Name             : Kelola_Informasi.php
 *  File Type             : Controller
 *  File Package          : CI_Controller
 ** * * * * * * * * * * * * * * * * * **
 *  Author                : Rizky Ardiansyah
 *  Date Created          : 07/08/2022
 *  Quots of the code     : 'Hanya seorang yang hobi berbicara dengan komputer.'
 */
class Kelola_Informasi extends CI_Controller
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
        $this->load->model('M_informasi', 'informasi');
    }

    public function index()
    {
        $data['title'] = 'PORTAL SPSI';
        $data['page'] = 'Admin';
        $data['subpage'] = 'Kelola Informasi';
        $data['content'] = 'page/admin/v_kelola_informasi';
        $this->load->view('template', $data);
    }
    function dataready($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    public function insert_data()
    {
        $data_post = $this->input->post();
        $dateNow = date('Y-m-d');
        $data_insert = [
            'tgl_post' => $dateNow,
            'judul' => $data_post['inputJudul'],
            'isi' => $data_post['inputIsi'],
            // 'isi' => $this->dataready($data_post['inputIsi']),
            'gambar' => 'test.jpg',
            'pembuat' => $this->session->userdata('user_id')
        ];
        $insert = $this->informasi->insert_data($data_insert);
        if (!$insert) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">Error</div>');
            redirect('admin/kelola_informasi', 'refresh');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Berita berhasil disimpan.</div>');
            redirect('admin/kelola_informasi', 'refresh');
        }
    }

    public function get_data()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            $filter = null;
            $search = null;
            if (isset($data_post['id'])) {
                $resData = $this->informasi->get_data(['id' => $data_post['id']])->row_array();
                // $date_now = date('Y-m-d H:i:s');
                $data_user = $this->users->get_data(['id' => $resData['pembuat']])->row_array();
                $resData['pembuat'] = $data_user['username'];
                $resData['id_pembuat'] = $data_user['id'];
            } else {
                $resData = $this->informasi->get_data($filter, $search)->result_array();
                // $date_now = date('Y-m-d H:i:s');
                foreach ($resData as $i => $val) {
                    $data_user = $this->users->get_data(['id' => $val['pembuat']])->row_array();
                    $resData[$i]['pembuat'] = $data_user['username'];
                    $resData[$i]['id_pembuat'] = $data_user['id'];
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

    public function delete_data()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            $delete = $this->informasi->delete_data(['id' => $data_post['id']]);
            if (!$delete) {
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
}
