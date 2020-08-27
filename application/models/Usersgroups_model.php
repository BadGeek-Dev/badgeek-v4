<?php

class Usersgroups_Model extends CI_Model
{
    public $user_id;
    public $group_id;

    const DB_BASE = "users_groups";
    const GROUPE_ADMIN       = 1;
    const GROUPE_PODITEURS   = 2;
    const GROUPE_PODCASTEURS = 3;

    public function insertUserInGroup($id_user, $id_group)
    {
        $resultat = $this->db->select()->where("user_id", $id_user)->where("group_id", $id_group)->get(self::DB_BASE);
        if($resultat->num_rows())
        {
            return;
        }
        $this->user_id = $id_user;
        $this->group_id = $id_group;
        $this->db->insert(self::DB_BASE, $this);
    }

    public function removeUserFromGroup($id_user, $id_group)
    {
        $resultat = $this->db->select()->where("user_id", $id_user)->where("group_id", $id_group)->get(self::DB_BASE);
        if($resultat->num_rows())
        {
            $user_group = $resultat->result()[0];
            $this->db->delete(self::DB_BASE, array("id"=>$user_group->id));
        }
    }
}
