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
        
    }

    public function index()
    {
        $this->load->helper('url');
        $this->load->view('templates/header');
        $this->load->view("public/index", array("user" => $this->user));
        $this->load->view('templates/footer');
    }
}
