<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  File Name             : Dashboard.php
 *  File Type             : Controller
 *  File Package          : CI_Controller
 ** * * * * * * * * * * * * * * * * * **
 *  Author                : Rizky Ardiansyah
 *  Date Created          : 02/08/2022
 *  Quots of the code     : 'Hanya seorang yang hobi berbicara dengan komputer.'
 */
class Dashboard extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		if (!logged_in()) {
			$this->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Anda tidak mempunyai akses, silahkan login!</div>');
			redirect('auth/login', 'refresh');
		};
		// $this->load->model('M_users', 'users');
		// $this->load->model('Auth_model', 'authmodel');
	}
	public function index()
	{
		$data['title'] = 'PORTAL SPSI';
		$data['page'] = 'Dashboard ' . $this->session->userdata('role');
		$data['subpage'] = 'Dashboard ' . $this->session->userdata('role');
		$data['content'] = 'page/v_dashboard_' . $this->session->userdata('role');
		$this->load->view('template', $data);
	}
}
