<?php

require_once APPPATH . 'core/Badgeek_Controller.php'; 

class Badgeek extends Badgeek_Controller
{
    public function index()
    {

        $this->load->model('Articles_model');
        $result = $this->Articles_model->getAllArticlesVisible();
        $this->template->load('public/index', array("result" => $result, "liste_BreadcrumbItems" => array(
            BreadcrumbItem::getBreadcrumbItemAccueil(true)
        )));
    }
}
