<?php

class Gizi_model extends CI_Model
{
    public function getBbu($id = null)
    {
        if ($id === null) {
            return $this->db->get('tbl_bbu')->result_array();
        } else {
            return $this->db->get_where('tbl_bbu', ['id_bbu' => $id])->result_array();
        }
    }

    public function getIdByTabel()
    {
        $query = "SELECT `tbl_bbu`.*, `tbl_balita`.`nama_balita`
                    FROM `tbl_bbu` JOIN `tbl_balita`
                    ON `tbl_bbu`.`id_balita` = `tbl_balita`.`id_balita`";
        return $this->db->query($query)->result_array();
    }
    public function getGiziBbu($id = null)
    {
        if ($id === null) {
            $query = "SELECT `tbl_gizibbu`.*, `tbl_balita`.`nama_balita`
                    FROM `tbl_gizibbu` JOIN `tbl_balita`
                    ON `tbl_gizibbu`.`id_balita` = `tbl_balita`.`id_balita`";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `tbl_gizibbu`.*, `tbl_balita`.`nama_balita`
                    FROM `tbl_gizibbu` JOIN `tbl_balita`
                    ON `tbl_gizibbu`.`id_balita` = `tbl_balita`.`id_balita`
                    WHERE `tbl_gizibbu`.`id_balita`='$id'
                    ORDER BY `tbl_gizibbu`.`update_bbu` DESC";
            return $this->db->query($query)->result_array();
        }
    }
    public function getGiziTbu($id = null)
    {
        if ($id === null) {
            $query = "SELECT `tbl_gizitbu`.*, `tbl_balita`.`nama_balita`
                    FROM `tbl_gizitbu` JOIN `tbl_balita`
                    ON `tbl_gizitbu`.`id_balita` = `tbl_balita`.`id_balita`";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `tbl_gizitbu`.*, `tbl_balita`.`nama_balita`
                    FROM `tbl_gizitbu` JOIN `tbl_balita`
                    ON `tbl_gizitbu`.`id_balita` = `tbl_balita`.`id_balita`
                    WHERE `tbl_gizitbu`.`id_balita`='$id'
                    ORDER BY `tbl_gizitbu`.`update_tbu` DESC";
            return $this->db->query($query)->result_array();
        }
    }
    public function getGiziBbtb($id = null)
    {
        if ($id === null) {
            $query = "SELECT `tbl_gizibbtb`.*, `tbl_balita`.`nama_balita`
                    FROM `tbl_gizibbtb` JOIN `tbl_balita`
                    ON `tbl_gizibbtb`.`id_balita` = `tbl_balita`.`id_balita`";
            return $this->db->query($query)->result_array();
        } else {
            $query = "SELECT `tbl_gizibbtb`.*, `tbl_balita`.`nama_balita`
                    FROM `tbl_gizibbtb` JOIN `tbl_balita`
                    ON `tbl_gizibbtb`.`id_balita` = `tbl_balita`.`id_balita`
                    WHERE `tbl_gizibbtb`.`id_balita`='$id'
                    ORDER BY `tbl_gizibbtb`.`update_bbtb` DESC";
            return $this->db->query($query)->result_array();
        }
    }

    public function getMedian($kelamin, $umur)
    {
        $query = "SELECT median FROM tbl_bbu WHERE kelamin='$kelamin' AND umur=$umur";
        return $this->db->query($query)->result_array();
    }
    public function getMin($kelamin, $umur)
    {
        $query = "SELECT min1SD FROM tbl_bbu WHERE kelamin='$kelamin' AND umur=$umur";
        return $this->db->query($query)->result_array();
    }
    public function getPlus($kelamin, $umur)
    {
        $query = "SELECT plus1SD FROM tbl_bbu WHERE kelamin='$kelamin' AND umur=$umur";
        return $this->db->query($query)->result_array();
    }

    public function inputBBU($data)
    {
        $this->db->insert('tbl_gizibbu', $data);
        return $this->db->affected_rows();
    }

    // tinggi badan berdasarkan umur
    public function getMedianTbu($kelamin, $umur)
    {
        $query = "SELECT median FROM tbl_tbu WHERE kelamin='$kelamin' AND umur=$umur";
        return $this->db->query($query)->result_array();
    }
    public function getMinTbu($kelamin, $umur)
    {
        $query = "SELECT min1SD FROM tbl_tbu WHERE kelamin='$kelamin' AND umur=$umur";
        return $this->db->query($query)->result_array();
    }
    public function getPlusTbu($kelamin, $umur)
    {
        $query = "SELECT plus1SD FROM tbl_tbu WHERE kelamin='$kelamin' AND umur=$umur";
        return $this->db->query($query)->result_array();
    }
    public function inputTBU($data)
    {
        $this->db->insert('tbl_gizitbu', $data);
        return $this->db->affected_rows();
    }

    // tinggi badan berdasarkan umur
    public function getMedianBbtb($kelamin, $kat_umur, $tinggi_badan)
    {
        $query = "SELECT median FROM tbl_bbtb WHERE kelamin='$kelamin' AND kat_umur=$kat_umur AND tinggi_badan=$tinggi_badan";
        return $this->db->query($query)->result_array();
    }
    public function getMinBbtb($kelamin, $kat_umur, $tinggi_badan)
    {
        $query = "SELECT min1SD FROM tbl_bbtb WHERE kelamin='$kelamin' AND kat_umur=$kat_umur AND tinggi_badan=$tinggi_badan";
        return $this->db->query($query)->result_array();
    }
    public function getPlusBbtb($kelamin, $kat_umur, $tinggi_badan)
    {
        $query = "SELECT plus1SD FROM tbl_bbtb WHERE kelamin='$kelamin' AND kat_umur=$kat_umur AND tinggi_badan=$tinggi_badan";
        return $this->db->query($query)->result_array();
    }
    public function inputBBTB($data)
    {
        $this->db->insert('tbl_gizibbtb', $data);
        return $this->db->affected_rows();
    }
}
