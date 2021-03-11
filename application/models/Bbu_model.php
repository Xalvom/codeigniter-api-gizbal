<?php

class Bbu_model extends CI_Model
{
    public function getBbu($id = null)
    {
        if ($id === null) {
            return $this->db->get('tbl_bbu')->result_array();
        } else {
            return $this->db->get_where('tbl_bbu', ['id_bbu' => $id])->result_array();
        }
    }
}
