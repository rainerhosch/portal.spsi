<?php
defined('BASEPATH') or exit('No direct script access allowed');
/**
 *  File Name             : M_pengundurandiri.php
 *  File Type             : Model
 *  File Package          : CI_Models
 ** * * * * * * * * * * * * * * * * * **
 *  Author                : Rizky Ardiansyah
 *  Date Created          : 08/08/2022
 *  Quots of the code     : 'sebuah code program bukanlah sebatas perintah-perintah yang ditulis di komputer, melainkan sebuah kesempatan berkomunikasi antara komputer dan manusia. (bagi yang tidak punya teman wkwk)'
 */
class M_pengundurandiri extends CI_Model
{
    public function get_data($condition = null, $search = null)
    {
        $this->db->select('*');
        $this->db->from('tbl_pengunduran_diri');
        if ($condition != null) {
            $this->db->where($condition);
        }

        if ($search != null) {
            $this->db->like('alasan_pengunduran_diri', $search, 'after');
        }
        $this->db->order_by('id', 'DESC');
        return $this->db->get();
    }

    public function insert_data($data)
    {
        $insert = $this->db->insert('tbl_pengunduran_diri', $data);
        if ($insert) {
            $insert_id = $this->db->insert_id();
            return  $insert_id;
        } else {
            return false;
        }
    }
    function update_data($data, $where)
    {
        $this->db->update('tbl_pengunduran_diri', $data, $where);
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete_data($where)
    {
        $this->db->where($where);
        $this->db->delete('tbl_pengunduran_diri');
        if ($this->db->affected_rows() > 0) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
}
