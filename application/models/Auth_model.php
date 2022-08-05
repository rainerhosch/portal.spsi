<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *  File Name             : Auth_model.php
 *  File Type             : Model
 *  File Package          : CI_Models
 ** * * * * * * * * * * * * * * * * * **
 *  Author                : Rizky Ardiansyah
 *  Date Created          : 02/08/2022
 *  Quots of the code     : 'sebuah code program bukanlah sebatas perintah-perintah yang ditulis di komputer, melainkan sebuah kesempatan berkomunikasi antara komputer dan manusia. (bagi yang tidak punya teman wkwk)'
 */
class Auth_model extends CI_Model
{
    public function get_data($condition = null)
    {
        $this->db->select('*');
        $this->db->from();
        if ($condition != null) {
            $this->db->where($condition);
        }
        return $this->db->get();
    }

    public function get_login_attempts($condition = null)
    {
        $this->db->select('*');
        $this->db->from('login_attempts');
        if ($condition != null) {
            $this->db->where($condition);
        }
        return $this->db->get();
    }


    public function insert_login_attempts($data)
    {
        $this->db->insert('login_attempts', $data);
        $insert_id = $this->db->insert_id();
        if ($insert_id != null) {
            return  $insert_id;
        } else {
            return FALSE;
        }
    }

    public function delete_login_attempts($where)
    {
        $this->db->delete('login_attempts', $where);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
