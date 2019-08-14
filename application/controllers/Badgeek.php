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
        $this->load->view('templates/header', array(
            "user" => $this->user, 
            "extras" => array("js" => array("assets/js/register.js"))));
        $sid = refreshSid();
        $this->load->view("public/index", array("sid" => $sid));
        $this->load->view('templates/footer');
    }

}
