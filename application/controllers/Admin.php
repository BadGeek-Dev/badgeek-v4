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
        //Gestion fil d'Ariane
        $this->template->load_admin('public/Admin/admin', array(
            "liste_BreadcrumbItems" => $this->initBreadcrumbItem(true)
        ));
    }

    public function stats()
    {
        $this->load->model('Searchstats_model');
        $result = $this->Searchstats_model->admin_stats();

        $this->template->load_admin('admin/stats', array(
            "result" => $result, 
            "liste_BreadcrumbItems" => $this->initBreadcrumbItem(true)
        ));
    }

    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueilAdmin($current));
    }

    private function getBreadcrumbItems($extra_liste_items)
    {
        if(!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
        return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
    }

}
