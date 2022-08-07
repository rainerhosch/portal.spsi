<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *  File Name             : Kelola_Kegiatan.php
 *  File Type             : Controller
 *  File Package          : CI_Controller
 ** * * * * * * * * * * * * * * * * * **
 *  Author                : Rizky Ardiansyah
 *  Date Created          : 07/08/2022
 *  Quots of the code     : 'Hanya seorang yang hobi berbicara dengan komputer.'
 */
class Kelola_Kegiatan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        date_default_timezone_set('Asia/Jakarta');
        if (!logged_in()) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Anda tidak mempunyai akses, silahkan login!</div>');
            redirect('auth/login', 'refresh');
        };
        $this->load->model('M_masterdata', 'masterdata');
        $this->load->model('M_kegiatan', 'kegiatan');
    }

    public function index()
    {
        $data['title'] = 'PORTAL SPSI';
        $data['page'] = 'Admin';
        $data['subpage'] = 'Kelola Kegiatan';
        $data['content'] = 'page/admin/v_kelola_kegiatan';
        $this->load->view('template', $data);
    }

    public function add_data_kegiatan()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            $data_insert = [
                'tgl' => $data_post['inputTgl'],
                'jam' => $data_post['inputJam'],
                'desc' => $data_post['inputDescKegiatan'],
                'lokasi' => $data_post['inputLokasi']
            ];
            $table = 'struktur_org';
            $isert = $this->kegiatan->insert_data($data_insert);
            if ($isert) {
                $data = [
                    'status' => true,
                    'code' => 200,
                    'icon' => 'success',
                    'message' => 'Success add data',
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

    public function edit_data_kegiatan()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            $id_update = $data_post['editId'];
            $data_update = [
                'tgl' => $data_post['editTgl'],
                'jam' => $data_post['editJam'],
                'desc' => $data_post['editDesc'],
                'lokasi' => $data_post['editLokasi']
            ];
            $table = 'struktur_org';
            $isert = $this->kegiatan->insert_data($data_update);
            if ($isert) {
                $data = [
                    'status' => true,
                    'code' => 200,
                    'icon' => 'success',
                    'message' => 'Success add data',
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

    public function get_data()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            $resData = $this->kegiatan->get_data()->result_array();
            $date_now = date('Y-m-d H:i:s');
            foreach ($resData as $i => $val) {
                $seconds = (strtotime($date_now) - strtotime($val['tgl'] . ' ' . $val['jam']));
                if ($seconds > 0) {
                    $resData[$i]['status'] = 1;
                    $resData[$i]['info'] = 'Kegiatan telah dilaksanakan.';
                } else {
                    $resData[$i]['status'] = 0;
                    $resData[$i]['info'] = 'Kegiatan belum dilaksanakan.';
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
            $delete = $this->kegiatan->delete_data(['id' => $data_post['id']]);
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
