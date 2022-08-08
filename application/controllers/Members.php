<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *  File Name             : Members.php
 *  File Type             : Controller
 *  File Package          : CI_Controller
 ** * * * * * * * * * * * * * * * * * **
 *  Author                : Rizky Ardiansyah
 *  Date Created          : dd/mm/yyyy
 *  Quots of the code     : 'Hanya seorang yang hobi berbicara dengan komputer.'
 */
class Members extends CI_Controller
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
        $this->load->model('M_masterdata', 'masterdata');
        $this->load->model('M_users', 'users');
        $this->load->model('M_informasi', 'informasi');
        $this->load->model('M_kegiatan', 'kegiatan');
    }

    public function pengunduran_diri()
    {
        $data['title'] = 'PORTAL SPSI';
        $data['page'] = 'Pengunduran Anggota';
        $data['subpage'] = 'Pengunduran Anggota';
        $data['content'] = 'page/members/v_pengunduran_anggota.php';
        $this->load->view('template', $data);
    }

    public function input_pengunduran_diri()
    {
        $data_post = $this->input->post();
        $data_insert = [
            'user_id' => $this->session->userdata('user_id'),
            'alasan_pengunduran_diri' => $data_post['inputAlasanPengunduran'],
            'status' => 0
        ];
        $insert = $this->pengundurandiri->insert_data($data_insert);
        if (!$insert) {
            $this->session->set_flashdata('message', '<div class="alert alert-danger text-center">Error</div>');
            redirect('members/pengunduran_diri', 'refresh');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-success text-center">Berita berhasil disimpan.</div>');
            redirect('members/pengunduran_diri', 'refresh');
        }
    }

    public function lihat_informasi()
    {
        $data['title'] = 'PORTAL SPSI';
        $data['page'] = 'Lihat Informasi';
        $data['subpage'] = 'Lihat Informasi';
        $data['content'] = 'page/members/v_lihat_informasi.php';
        $this->load->view('template', $data);
    }

    public function lihat_kegiatan()
    {
        $data['title'] = 'PORTAL SPSI';
        $data['page'] = 'Lihat Kegiatan';
        $data['subpage'] = 'Lihat Kegiatan';
        $data['content'] = 'page/members/v_lihat_kegiatan.php';
        $this->load->view('template', $data);
    }

    public function lihat_struktur_organisasi()
    {

        $data['title'] = 'PORTAL SPSI';
        $data['page'] = 'Dashboard ' . $this->session->userdata('role');
        $data['subpage'] = 'Lihat Struktur SPSI';
        $data['content'] = 'page/members/v_lihat_struktur_organisasi.php';
        $this->load->view('template', $data);
    }
}
