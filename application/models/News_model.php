<?php

class News_Model extends CI_Model
{
    function __construct() {
        $this->load->database();
    }   

    public function get_news($slug = FALSE)
    {
        if (!$slug){
            $query = $this->db->get('news');
            return $query->result_array();
        }

        $query = $this->db->get_where('news', array('slug' => $slug));
        return $query->row_array();
    }
}
