<?php

class User_model extends CI_Model
{

    public function getUser($id = null)
    {
        if ($id === null) {
            return $this->db->get('tbl_user')->result_array();
        } else {
            return $this->db->get_where('tbl_user', ['id_user' => $id])->result_array();
        }
    }

    public function deleteUser($id_user)
    {
        $this->db->delete('tbl_user', ['id_user' => $id_user]);
        return $this->db->affected_rows();
    }

    public function createUser($data)
    {
        $this->db->insert('tbl_user', $data);
        return $this->db->affected_rows();
    }

    public function updateUser($data, $id_user)
    {
        $this->db->update('tbl_user', $data, ['id_user' => $id_user]);
        return $this->db->affected_rows();
    }

    public function loginUser($email_user)
    {
        return $this->db->get_where('tbl_user', ['email_user' => $email_user])->result_array();
    }

    public function loginUserApp($email_user, $password_user)
    {
        $query = "SELECT * FROM tbl_user WHERE email_user='$email_user' AND password_user='$password_user'";
        return $this->db->query($query)->result_array();
    }

    public function joinUser()
    {
        $query = "SELECT `tbl_user`.*, `tbl_role`.`nama_role`
                    FROM `tbl_user` JOIN `tbl_role`
                    ON `tbl_user`.`level_user` = `tbl_role`.`id_role`";
        return $this->db->query($query)->result_array();
    }
}
