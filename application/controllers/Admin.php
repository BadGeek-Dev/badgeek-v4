<?php

require_once APPPATH . 'core/Badgeek_Controller.php';

class Admin extends Badgeek_Controller
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->checkAdminRights();
        $this->load->model('Articles_model');
    }

    public function index()
    {
        $result = $this->Articles_model->getAllArticles();
        $this->template->load_admin('public/Admin/admin', array("result" => $result));
    }



}
