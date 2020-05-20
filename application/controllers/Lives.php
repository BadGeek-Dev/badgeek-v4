<?php

require_once APPPATH . 'core/Badgeek_Controller.php';

class Lives extends Badgeek_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->model('Lives_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
//        $result = $this->Lives_model->getLiveByMember($this->session->userdata('user_id'));
        $this->template->load('public/lives/index', array(
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true)
        ));
    }


    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueilAdmin(false), new BreadcrumbItem("Articles","/admin/articles", $current));
    }

    private function getBreadcrumbItems($extra_liste_items)
    {
        if(!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
        return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
    }


}