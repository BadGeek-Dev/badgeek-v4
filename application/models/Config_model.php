<?php

class Config_model extends CI_Model
{
    const DB_TABLE = "config";

    public $nb_articles_homepage;

    public function init()
    {
        return $this->db->truncate(self::DB_TABLE) &&  $this->db->insert(self::DB_TABLE, [
            "id" => 1,
            "nb_articles_homepage" => 1
        ]);
    }

    public function loadConfig()
    {
        $CI = & get_instance();
        $CI->session->set_userdata('config', $this->getConfigBDD());
    }

    private function getConfigBDD()
    {
        return $this->db->select()->from(self::DB_TABLE)->limit("1")->get()->row_array();
    }

    public function setConfig($element, $value)
    {
        $this->db->update(self::DB_TABLE, [$element => $value]);
        $this->loadConfig();
    }


    /**
     * Get the value of nb_articles_homepage
     */ 
    public function getNb_articles_homepage()
    {
        return $this->nb_articles_homepage;
    }

    /**
     * Set the value of nb_articles_homepage
     *
     * @return  self
     */ 
    public function setNb_articles_homepage($nb_articles_homepage)
    {
        $this->nb_articles_homepage = $nb_articles_homepage;

        return $this;
    }
}