<?php

require_once APPPATH . 'core/Badgeek_Controller.php'; 

class Podcasts extends Badgeek_Controller 
{
    public function create()
    {
        $data = [];
        $this->template->load('public/index');
    }
}