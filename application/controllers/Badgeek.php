<?php

require_once APPPATH . 'core/Badgeek_Controller.php'; 

class Badgeek extends Badgeek_Controller
{
    public function index()
    {

        $this->load->database();
        $this->load->model('Articles_model');
        $result = $this->Articles_model->getAllArticlesVisible();
        foreach ($result as $row) {
            $data[] = (array)$row;
        }
        $this->template->load('public/index', array("result" => $data));
    }
}
