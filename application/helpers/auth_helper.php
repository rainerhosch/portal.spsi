<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *  File Name             : auth_helper.php
 *  File Type             : Helper
 *  File Package          : CI_Helper
 ** * * * * * * * * * * * * * * * * * **
 *  Author                : Rizky Ardiansyah
 *  Date Created          : 02/02/2022
 *  Quots of the code     : 'Code for change the world'
 */
function login_checker()
{
    $ci = get_instance();
    $is_login = $ci->session->userdata('is_login');
    if ($is_login === null) {
        $ci->session->set_flashdata('message', '<div class="alert alert-warning" role="alert">Anda tidak mempunyai akses, silahkan login!</div>');
        redirect('auth/login', 'refresh');
    } else {
        if ($ci->session->userdata('role') != null) {
            redirect('dashboard/' . $ci->session->userdata('role'), 'refresh');
        } else {
            redirect('auth/login', 'refresh');
        }
    }
}

function logged_in()
{
    $CI = &get_instance();
    $is_login = $CI->session->userdata('is_login');
    // $is_login = 1;
    if ($is_login === null) {
        return FALSE;
    } else {
        return TRUE;
    }
}

function save_data_session($data)
{
    $CI = &get_instance();
    $CI->load->model('M_users', 'users');
    $data_groups = $CI->users->get_users_groups(['users_groups.user_id' => $data['id']])->row_array();
    $data_session = [
        'user_id' => $data['id'],
        'username' => $data['username'],
        'email' => $data['email'],
        'role' => $data_groups['user_group'],
        'is_login' => true
    ];
    $CI->session->set_userdata($data_session);
}

// get ip client
function get_client_ip()
{
    $ipaddress = '';
    if (isset($_SERVER['HTTP_CLIENT_IP']))
        $ipaddress = $_SERVER['HTTP_CLIENT_IP'];
    else if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_X_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_X_FORWARDED'];
    else if (isset($_SERVER['HTTP_FORWARDED_FOR']))
        $ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
    else if (isset($_SERVER['HTTP_FORWARDED']))
        $ipaddress = $_SERVER['HTTP_FORWARDED'];
    else if (isset($_SERVER['REMOTE_ADDR']))
        $ipaddress = $_SERVER['REMOTE_ADDR'];
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}


/**
 * Fungsi untuk handle percobaan login
 */

function check_login_attempts($data)
{
    $CI = &get_instance();
    $CI->load->model('Auth_model', 'auth_model');
    $data_attempts = $CI->auth_model->get_login_attempts(['login' => $data])->result_array();
    return $data_attempts;
}

function insert_login_attempts($data)
{
    $CI = &get_instance();
    $CI->load->model('Auth_model', 'auth_model');
    return $CI->authmodel->insert_login_attempts($data);
}

function remove_data_login_attempts($data)
{
    $CI = &get_instance();
    $CI->load->model('Auth_model', 'auth_model');
    return $CI->authmodel->delete_login_attempts(['login' => $data]);
}
