<?php

class Badgeek extends CI_Controller 
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->user = false;
        if($this->ion_auth->logged_in())
        {
            $this->user = $this->ion_auth->user()->row();
        }
       $this->load->helper(['badgeek']);
        
    }

    public function index()
    {
        $this->load->helper('url');
        $sid = refreshSid();
        $this->load->view('templates/header', array(
            "user" => $this->user, 
            "sid" => $sid,
            "extras" => array("js" => array("assets/js/header.js"))));
        $this->load->view("public/index", array());
        $this->load->view('templates/footer');
    }

    public function phpinfo()
    {
        phpinfo();
    }

}
