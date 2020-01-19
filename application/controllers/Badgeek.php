<?php

require_once APPPATH . 'core/Badgeek_Controller.php'; 

class Badgeek extends Badgeek_Controller
{
    public function index()
    {

        $this->load->database();
        $query = $this->db->query('SELECT badgeek.articles.id,badgeek.articles.title,badgeek.articles.content,badgeek.articles.created_at, badgeek.users.username FROM badgeek.articles INNER JOIN badgeek.users ON badgeek.articles.id_author = badgeek.users.id WHERE badgeek.articles.id > 0');
        foreach ($query->result() as $row) {
            $data[] = (array)$row;
        }
        $this->template->load('public/index', array("result" => $data));
    }
}
