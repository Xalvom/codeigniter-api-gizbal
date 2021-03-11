<?php

class Balita_model extends CI_Model
{

    public function getBalita($id = null)
    {
        if ($id === null) {
            return $this->db->get('tbl_balita')->result_array();
        } else {
            return $this->db->get_where('tbl_balita', ['id_balita' => $id])->result_array();
        }
    }

    public function deleteBalita($id_balita)
    {
        // $query = "DELETE `tbl_balita`.*, `tbl_gizibbu`.*
        //             FROM `tbl_balita` JOIN `tbl_gizibbu`
        //             ON `tbl_balita`.`id_balita` = `tbl_gizibbu`.`id_balita`
        //             WHERE `tbl_balita`.`id_balita`='$id_balita'";
        // return $this->db->delete($query)->affected_rows();
        $this->db->delete('tbl_balita', ['id_balita' => $id_balita]);
        $this->db->delete('tbl_gizibbu', ['id_balita' => $id_balita]);
        $this->db->delete('tbl_gizitbu', ['id_balita' => $id_balita]);
        return $this->db->affected_rows();
    }

    public function createBalita($data)
    {
        $this->db->insert('tbl_balita', $data);
        return $this->db->affected_rows();
    }

    public function updateBalita($data, $id_balita)
    {
        $this->db->update('tbl_balita', $data, ['id_balita' => $id_balita]);
        return $this->db->affected_rows();
    }

    public function getBalitaById($id = null)
    {
        if ($id === null) {
            return $this->db->get('tbl_balita')->result_array();
        } else {
            return $this->db->get_where('tbl_balita', ['id_user' => $id])->result_array();
        }
    }
}
