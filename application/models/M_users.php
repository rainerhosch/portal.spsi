<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *  File Name             : M_Users.php
 *  File Type             : Model
 *  File Package          : CI_Models
 ** * * * * * * * * * * * * * * * * * **
 *  Author                : Rizky Ardiansyah
 *  Date Created          : 02/08/2022
 *  Quots of the code     : 'sebuah code program bukanlah sebatas perintah-perintah yang ditulis di komputer, melainkan sebuah kesempatan berkomunikasi antara komputer dan manusia. (bagi yang tidak punya teman wkwk)'
 */
class M_Users extends CI_Model
{
    public function get_data($condition = null, $search = null)
    {
        $this->db->select('*');
        $this->db->from('users');
        if ($condition != null) {
            $this->db->where($condition);
        }

        if ($search != null) {
            $this->db->like('first_name', $search, 'after');
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get();
    }

    public function get_users_groups($condition = null)
    {
        $this->db->select('groups.name as user_group');
        $this->db->from('users_groups');
        $this->db->join('groups', 'groups.id=users_groups.group_id');
        if ($condition != null) {
            $this->db->where($condition);
        }
        return $this->db->get();
    }

    // Add new 
    public function add_data_anggota($data)
    {
        $insert = $this->db->insert('users', $data);
        if ($insert) {
            $insert_id = $this->db->insert_id();
            return  $insert_id;
        } else {
            return false;
        }
    }

    public function add_users_groups($data)
    {
        return $this->db->insert('users_groups', $data);
    }

    function updateData($data, $where)
    {
        $this->db->update('users', $data, $where);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function deleteData($table, $where)
    {
        $this->db->where($where);
        $this->db->delete($table);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
