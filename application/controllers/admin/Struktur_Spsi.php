<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *  File Name             : Struktur_Spsi.php
 *  File Type             : Controller
 *  File Package          : CI_Controller
 ** * * * * * * * * * * * * * * * * * **
 *  Author                : Rizky Ardiansyah
 *  Date Created          : 06/08/2022
 *  Quots of the code     : 'Hanya seorang yang hobi berbicara dengan komputer.'
 */
class Struktur_Spsi extends CI_Controller
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
        $this->load->model('M_users', 'users');
    }

    public function index()
    {
        $data['title'] = 'PORTAL SPSI';
        $data['page'] = 'Admin';
        $data['subpage'] = 'Struktur SPSI';
        $data['content'] = 'page/admin/v_struktur_organisasi';
        $this->load->view('template', $data);
    }

    public function get_data_struktur()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            $table = 'struktur_org';
            $struktur_org = $this->masterdata->get_data($table)->result_array();
            if (!$struktur_org) {
                $data = [
                    'status' => false,
                    'code' => 500,
                    'icon' => 'error',
                    'message' => 'Koneksi Server Error!',
                    'data' => null
                ];
            } else {
                foreach ($struktur_org as $i => $val) {
                    $struktur_org[$i]['data_user'] = $this->users->get_data(['id' => $val['user_id']])->row();
                    $struktur_org[$i]['data_jabatan'] = $this->masterdata->get_data('m_jabatan_org', ['id' => $val['jabatan_id']])->row_array();
                }
                $data = [
                    'status' => true,
                    'code' => 200,
                    'icon' => 'success',
                    'message' => 'Data Found!.',
                    'data' => $struktur_org
                ];
            }
            echo json_encode($data);
        } else {
            show_404();
        }
    }

    // public function get_bagan_struktur()
    // {
    //     if ($this->input->is_ajax_request()) {
    //         $data_post = $this->input->post();
    //         $table = 'struktur_org';
    //         $struktur_org = $this->masterdata->get_data($table)->result_array();
    //         if (!$struktur_org) {
    //             $data = [
    //                 'status' => false,
    //                 'code' => 500,
    //                 'icon' => 'error',
    //                 'message' => 'Koneksi Server Error!',
    //                 'data' => null
    //             ];
    //         } else {
    //             foreach ($struktur_org as $i => $val) {
    //                 $data_jabatan[$i] = $this->masterdata->get_data('m_jabatan_org', ['id' => $val['jabatan_id']])->row_array();
    //                 $data_user[$i] = $this->users->get_data(['id' => $val['user_id']])->row_array();
    //                 $data_bagan[$i] = [
    //                     'id' => $data_jabatan[$i]['id'],
    //                     'text' => $data_jabatan[$i]['nama'],
    //                     'title' => $data_user[$i]['first_name'] . ' ' . $data_user[$i]['last_name'],
    //                     'width' => '350',
    //                     'height' => '100',
    //                     'dir' => 'horizontal',
    //                     // 'dir' => base_url('assets/data-file'),
    //                     'img' => $data_user[$i]['user_img'],
    //                 ];
    //             }
    //             $jml_bagan = count($data_bagan);
    //             foreach ($data_bagan as $j => $bagan) {
    //                 if ($bagan['id'] != '1') {
    //                     $data_bagan[$jml_bagan] = [
    //                         'id' => '1-' . $bagan['id'],
    //                         'from' => '1',
    //                         'to' => $bagan['id'],
    //                         'type' => 'line'
    //                     ];
    //                     $jml_bagan++;
    //                 }
    //             }
    //             $data = [
    //                 'status' => true,
    //                 'code' => 200,
    //                 'icon' => 'success',
    //                 'message' => 'Data Found!.',
    //                 'data' => $data_bagan
    //             ];
    //         }
    //         echo json_encode($data);
    //     } else {
    //         show_404();
    //     }
    // }

    public function cari_data_anggota()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            $where = null;
            $search = null;
            if (isset($data_post['search'])) {
                $search =  $data_post['search'];
                $struktur_org = $this->masterdata->get_data('struktur_org')->result_array();
                $id_user = [];
                foreach ($struktur_org as $i => $val) {
                    $id_user[$i] = $val['user_id'];
                }
                $ids = implode(",", $id_user);
                $where = 'id NOT IN (' . $ids . ')';
            }
            $resData = $this->users->get_data($where, $search)->result_array();
            foreach ($resData as $key => $value) {
                $response[$key] = [
                    'label' => $value['first_name'] . ' ' . $value['last_name'],
                    'value' => $value['email'],
                    'id' => $value['id']
                ];
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
                    'data' => $response,
                ];
            }
            echo json_encode($data);
        } else {
            show_404();
        }
    }

    public function get_master_jabatan()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            $table = 'm_jabatan_org';
            $table2 = 'struktur_org';
            if (isset($data_post['id'])) {
                $resData = $this->masterdata->get_data($table, ['id' => $data_post['id']])->row_array();
            } else if (isset($data_post['select'])) {
                $struktur_org = $this->masterdata->get_data($table2)->result_array();
                $id_jabatan = [];
                foreach ($struktur_org as $i => $val) {
                    $id_jabatan[$i] = $val['jabatan_id'];
                }
                $ids = implode(",", $id_jabatan);
                $where = 'id NOT IN (' . $ids . ')';
                $resData = $this->masterdata->get_data($table, $where)->result_array();
            } else {
                $resData = $this->masterdata->get_data($table)->result_array();
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
                    'data' => $resData,
                ];
            }
            echo json_encode($data);
        } else {
            show_404();
        }
    }

    public function get_bagan()
    {
        $data_bagan = [];
        $struktur_org = $this->masterdata->get_data('struktur_org')->result_array();
        foreach ($struktur_org as $i => $val) {
            $data_jabatan[$i] = $this->masterdata->get_data('m_jabatan_org', ['id' => $val['jabatan_id']])->row_array();
            // $data[$i]['jabatan'] = $data_jabatan[$i]['nama'];
            $data_user[$i] = $this->users->get_data(['id' => $val['user_id']])->row_array();
            $data_bagan[$i] = [
                'id' => $data_jabatan[$i]['id'],
                'text' => $data_jabatan[$i]['nama'],
                'title' => $data_user[$i]['first_name'] . ' ' . $data_user[$i]['last_name'],
                'width' => '350',
                'height' => '100',
                'dir' => 'horizontal',
                // 'dir' => base_url('assets/data-file'),
                'img' => base_url('assets/img/') . $data_user[$i]['user_img'],
            ];
        }
        $jml_bagan = count($data_bagan);
        foreach ($data_bagan as $j => $bagan) {
            if ($bagan['id'] != '1') {
                $data_bagan[$jml_bagan] = [
                    'id' => '1-' . $bagan['id'],
                    'from' => '1',
                    'to' => $bagan['id'],
                    'type' => 'line'
                ];
                $jml_bagan++;
            }
        }
        echo json_encode($data_bagan);
    }
    public function generate_bagan_json_file()
    {
        $data_bagan = [];
        $struktur_org = $this->masterdata->get_data('struktur_org')->result_array();
        foreach ($struktur_org as $i => $val) {
            $data_jabatan[$i] = $this->masterdata->get_data('m_jabatan_org', ['id' => $val['jabatan_id']])->row_array();
            // $data[$i]['jabatan'] = $data_jabatan[$i]['nama'];
            $data_user[$i] = $this->users->get_data(['id' => $val['user_id']])->row_array();
            $data_bagan[$i] = [
                'id' => $data_jabatan[$i]['id'],
                'text' => $data_jabatan[$i]['nama'],
                'title' => $data_user[$i]['first_name'] . ' ' . $data_user[$i]['last_name'],
                'width' => '350',
                'height' => '100',
                'dir' => 'horizontal',
                // 'dir' => base_url('assets/data-file'),
                'img' => base_url('assets/img/') . $data_user[$i]['user_img'],
            ];
        }
        $jml_bagan = count($data_bagan);
        foreach ($data_bagan as $j => $bagan) {
            if ($bagan['id'] != '1') {
                $data_bagan[$jml_bagan] = [
                    'id' => '1-' . $bagan['id'],
                    'from' => '1',
                    'to' => $bagan['id'],
                    'type' => 'line'
                ];
                $jml_bagan++;
            }
        }
        // config folder
        $dir = FCPATH . 'assets/data-file';
        // JIKA DIREKTORI TIDAK ADA
        if (!is_dir($dir)) {
            mkdir($dir, 0777, true);
        }
        file_put_contents($dir . '/struktur_organisasi.json', json_encode($data_bagan));
    }

    public function add_data_struktur()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            $data_insert = [
                'user_id' => $data_post['inputIdUser'],
                'jabatan_id' => $data_post['inputJabatan']
            ];
            $table = 'struktur_org';
            $isert = $this->masterdata->insert_data($table, $data_insert);
            if ($isert) {
                // $this->generate_bagan_json_file();
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

    public function add_master_jabatan()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            $data_insert = [
                'nama' => $data_post['inputJabatan']
            ];
            $table = 'm_jabatan_org';
            $isert = $this->masterdata->insert_data($table, $data_insert);
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

    public function delete_data()
    {
        if ($this->input->is_ajax_request()) {
            $data_post = $this->input->post();
            $delete = $this->masterdata->delete_data($data_post['table'], ['id' => $data_post['id']]);
            if (!$delete) {
                $data = [
                    'status' => false,
                    'code' => 500,
                    'icon' => 'error',
                    'message' => 'Koneksi Server Error!',
                    'data' => null
                ];
            } else {
                // $this->generate_bagan_json_file();
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
