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


use \PhpOffice\PhpSpreadsheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

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
        $this->load->model('M_masterdata', 'masterdata');
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
                $resData = $this->users->get_data(['active !=' => 2])->result_array();
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
    function pre($var)
    {
        echo '<pre>';
        if (is_array($var)) {
            print_r($var);
        } else {
            var_dump($var);
        }
        echo '</pre>';
    }

    public function export_data_anggota()
    {
        $date_now = date('Y-m-d');
        $pecah_date = explode('-', $date_now);
        $thn = $pecah_date[0];
        $bln = $pecah_date[1];
        $tgl = $pecah_date[2];
        $FormatTanggal = new FormatTanggal;
        $str_bulan = $FormatTanggal->konversiBulan($bln);
        $label_date = $tgl . ' ' . $str_bulan . ' ' . $thn;

        $data_export = [];
        $data_anggota = $this->users->get_data()->result_array();
        foreach ($data_anggota as $i => $val) {
            $jabatan = 'Anggota';
            if ($val['id'] != 1) {
                $struktur = $this->masterdata->get_data('struktur_org', ['user_id' => $val['id']])->row_array();
                if ($struktur != null) {
                    $res_jabatan = $this->masterdata->get_data('m_jabatan_org', ['id' => $struktur['jabatan_id']])->row_array();
                    $jabatan = $res_jabatan['nama'];
                }
            } else {
                $jabatan = 'ADMIN';
            }
            $data_export[$i] = [
                'nama' => $val['first_name'] . ' ' . $val['last_name'],
                'email' => $val['email'],
                'phone' => $val['phone'],
                // 'status' => $val['active'],
                'departemen' => $val['departemen'],
                'jabatan' => $jabatan
            ];
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet(0);
        $sheet->setTitle($label_date);

        //define width of column
        $sheet->getColumnDimension('A')->setWidth(5.43);
        $sheet->getColumnDimension('B')->setWidth(30.00);
        $sheet->getColumnDimension('C')->setWidth(30.00);
        $sheet->getColumnDimension('D')->setWidth(25.00);
        $sheet->getColumnDimension('E')->setWidth(18.00);
        $sheet->getColumnDimension('F')->setWidth(18.00);

        //Define Style table
        $styleTitle = [
            'alignment' => [
                'vertical' => PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
                'horizontal' => PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER
            ],
        ];
        $styleHeader = [
            'fill' => [
                'fillType' => PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => '808080')
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['RGB' => '000000']
                ]
            ]
        ];
        $styleTable = [
            'fill' => [
                'fillType' => PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'F2F2F2')
            ],
            'borders' => [
                'allBorders' => [
                    'borderStyle' => PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['RGB' => '000000']
                ]
            ]
        ];

        $sheet->setCellValue('A1', 'DATA ANGGOTA SPSI');
        $sheet->mergeCells('A1:F2');
        $sheet->setCellValue('A3', 'PER ' . $label_date);
        $sheet->mergeCells('A3:F4');
        $sheet->getStyle('A1:F4')->getFont()->setSize(14);
        $sheet->getStyle('A1:F4')->getFont()->setBold(true);
        $sheet->getStyle('A1:F4')->applyFromArray($styleTitle); //styling header table

        $row_header = 5;
        $row_tbl = 6;
        $no = 1;
        $sheet->setCellValue('A' . $row_header, 'NO');
        $sheet->setCellValue('B' . $row_header, 'NAMA');
        $sheet->setCellValue('C' . $row_header, 'EMAIL');
        $sheet->setCellValue('D' . $row_header, 'NO TLP');
        $sheet->setCellValue('E' . $row_header, 'DEPARTEMEN');
        $sheet->setCellValue('F' . $row_header, 'JABATAN');
        $spreadsheet->getDefaultStyle()->getFont()->setName('Verdana');
        $sheet->getStyle('A' . $row_header . ':F' . $row_header)->getFont()->setBold(true);
        $sheet->getStyle('A' . $row_header . ':F' . $row_header)->applyFromArray($styleHeader);
        foreach ($data_export as $j => $val) {
            $sheet->setCellValue('A' . $row_tbl, $no);
            $sheet->setCellValue('B' . $row_tbl, $val['nama']);
            $sheet->setCellValue('C' . $row_tbl, $val['email']);
            $sheet->setCellValue('D' . $row_tbl, $val['phone']);
            $sheet->setCellValue('E' . $row_tbl, $val['departemen']);
            $sheet->setCellValue('F' . $row_tbl, $val['jabatan']);
            $sheet->getStyle('A' . $row_tbl . ':F' . $row_tbl)->applyFromArray($styleTable);
            $no++;
            $row_tbl++;
        }
        $filename = 'EXPORT DATA ANGGOTA SPSI (' . $label_date . ')';
        $writer = new Xlsx($spreadsheet);
        header('Content-Type:application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
        header('Cache-Control: max-age=0');
        $writer->save('php://output');
    }
}
