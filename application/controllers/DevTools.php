<?php

require_once APPPATH . 'core/Badgeek_Controller.php';

class DevTools extends Badgeek_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->checkAdminRights();
        $this->load->helper('cookie');

    }

    public function index()
    {
        $this->template->load_admin('dev/check_dev_password');
    }

    public function check_dev_password()
    {
        $fp = fopen(__DIR__."/../private/check_dev_password", "r");
        $hash_passwd = fgets($fp);
        fclose($fp);
        if($hash_passwd && $this->input->post("password") == hash("sha256", $hash_passwd))
        {
            //Ajoute le cookie d'authentification
            setcookie("check_dev_password", "1", 3600);
            redirect("dev/handleMigrations");
        }
        else
        {
            
        }
    }

    public function dev_handleMigrations()
    {

    }
}