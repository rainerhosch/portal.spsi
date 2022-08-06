<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *  File Name             : M_masterdata.php
 *  File Type             : Model
 *  File Package          : CI_Models
 ** * * * * * * * * * * * * * * * * * **
 *  Author                : Rizky Ardiansyah
 *  Date Created          : 06/08/2022
 *  Quots of the code     : 'sebuah code program bukanlah sebatas perintah-perintah yang ditulis di komputer, melainkan sebuah kesempatan berkomunikasi antara komputer dan manusia. (bagi yang tidak punya teman wkwk)'
 */
class M_masterdata extends CI_Model
{
    public function get_data($table, $condition = null)
    {
        $this->db->select('*');
        $this->db->from($table);
        if ($condition != null) {
            $this->db->where($condition);
        }
        $this->db->order_by('id', 'ASC');
        return $this->db->get();
    }

    public function insert_data($table, $data,)
    {
        $insert = $this->db->insert($table, $data);
        if ($insert) {
            $insert_id = $this->db->insert_id();
            return  $insert_id;
        } else {
            return false;
        }
    }
    public function update_data($table, $data, $where)
    {
        $this->db->update($table, $data, $where);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    public function delete_data($table, $where)
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
