<?php

class Badgeek_Controller extends CI_Controller 
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->user = false;
        if ($this->ion_auth->logged_in()) {
            $this->user = $this->ion_auth->user()->row();
        }
        $this->load->helper(['badgeek']);
    }

    public function real_url($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) ? true : false;
    }
}