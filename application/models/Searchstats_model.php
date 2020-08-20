<?php

class Searchstats_model extends CI_Model {

    public $id;
    public $query;

    public function insert()
    {
        $this->db->insert('searchstats', $this);
        $this->id = $this->db->insert_id();
    }

    public function update($searchstat)
    {
        $this->db->update('searchstats', $podcast, ['id' => $searchstat->id]);
    }

    public function delete($searchstat)
    {
        $this->db->delete('searchstats', ['id' => $searchstat->id]);
    }

    public function admin_stats()
    {
        $this->db->select('query, COUNT(id) as count');
        $this->db->from('searchstats');
        $this->db->group_by('query');
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of query
     */ 
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Set the value of query
     *
     * @return  self
     */ 
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }
}