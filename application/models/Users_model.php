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

    public function update($user)
    {
        $this->db->update('users', $user, ['id' => $user->id]);
    }

    public function bareFindOneById($id)
    {
        return $this->db->get_where('users', ['id' => $id])->row();
    }

    public function findOneById($id)
    {
        $this->db->select('users.id, users.username, users.email, users.last_login, users.active, GROUP_CONCAT(users_groups.group_id SEPARATOR ", ") AS groups_id');
        $this->db->from('users');
        $this->db->where(['users.id' => $id]);
        $this->db->join('users_groups', 'users.id = users_groups.user_id', 'inner');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result()[0] ?? null;
    }

    public function getAllUsers()
    {
        $this->db->select('users.id, users.username, users.email, users.last_login, users.active');
        $this->db->from('users');
        $this->db->join('users_groups', 'users.id = users_groups.user_id', 'inner');
        $this->db->where(['users_groups.group_id !=' => 1]);
        $this->db->group_by('users.id');
        $query = $this->db->get();
        
        return $query->result();
    }
}
