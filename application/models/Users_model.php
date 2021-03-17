<?php

class Users_Model extends CI_Model
{
    public $username;

    const DB_TABLE = "users";
    const NON_VALIDE = 0;
    const ACTIVE = 1;
    const DESACTIVE = 2;

    const LIBELLE_NON_VALIDE = "En cours de validation";
    const LIBELLE_ACTIVE = "Validé";
    const LIBELLE_DESACTIVE = "Désactivé";
    const LIBELLE_ADMIN = "Administrateur";

    public function updateUsername()
    {
        $this->username = $this->input->post("user");
        $this->db->update(self::DB_TABLE, $this, array("id" => $this->input->post("id")));
    }

    public function update($user)
    {
        $this->db->update(self::DB_TABLE, $user, ['id' => $user->id]);
    }

    public function bareFindOneById($id)
    {
        return $this->db->get_where(self::DB_TABLE, ['id' => $id])->row();
    }

    public function findOneById($id)
    {
        $this->db->select('users.id, users.username, users.email, users.last_login, users.active, GROUP_CONCAT(users_groups.group_id SEPARATOR ", ") AS groups_id');
        $this->db->from(self::DB_TABLE);
        $this->db->where(['users.id' => $id]);
        $this->db->join('users_groups', 'users.id = users_groups.user_id', 'inner');
        $this->db->limit(1);
        $query = $this->db->get();
        return $query->result()[0] ?? null;
    }

    public function getAllUsers($with_admin = true)
    {
        $this->db->select('users.id, users.username, users.email, users.last_login, users.active');
        $this->db->from(self::DB_TABLE);
        $this->db->join('users_groups', 'users.id = users_groups.user_id', 'inner');
        if(empty($with_admin))
        {
            $this->db->where(['users_groups.group_id !=' => 1]);
        }
        $this->db->group_by('users.id');
        $query = $this->db->get();
        
        return $query->custom_result_object(get_class($this));
    }
    public function isNonValide()
    {
        return $this->active == self::NON_VALIDE;
    }
    public function isActive()
    {
        return $this->active == self::ACTIVE;
    }
    public function isDesactive()
    {
        return $this->active == self::DESACTIVE;
    }
    public function isAdmin()
    {
        return $this->db->select(self::DB_TABLE.".id")
            ->from(self::DB_TABLE)
            ->join('users_groups', 'users.id = users_groups.user_id', 'inner')
            ->where([
                'users_groups.group_id =' => Badgeek_constantes::AUTH_GROUP_ADMIN, 
                'users.id=' => $this->id
            ])
            ->group_by('users.id')
            ->count_all_results() > 0;
    }

    public function getAdmins($champ = false)
    {
        return $this->db->select($champ ? "users.$champ" : "*")
            ->from(self::DB_TABLE)
            ->join('users_groups', 'users.id = users_groups.user_id', 'inner')
            ->where(['users_groups.group_id =' => Badgeek_constantes::AUTH_GROUP_ADMIN])
            ->group_by('users.id')
            ->get()
            ->result();
    }
}
