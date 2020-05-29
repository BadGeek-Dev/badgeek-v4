<?php

class Users_Model extends CI_Model
{
    public $username;

    const DB_TABLE = "users";

    public function updateUsername()
    {
        $this->username = $this->input->post("user");
        $this->db->update(self::DB_TABLE, $this, array("id" => $this->input->post("id")));
    }

    public function findOneById($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row();
    }
}
