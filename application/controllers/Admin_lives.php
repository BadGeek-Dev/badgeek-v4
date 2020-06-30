<?php

require_once APPPATH . 'core/Badgeek_Controller.php';

class Admin_lives extends Badgeek_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->checkAdminRights();
        $this->load->model('Lives_model');
    }

    public function index()
    {
        $result = $this->Lives_model->getLives();
        $this->template->load_admin('public/Admin/admin_lives', array(
            "result" => $result,
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true)
        ));
    }

    public function view($id)
    {
        $result = $this->Lives_model->getLiveById($id);
        $this->template->load_admin('public/Admin/admin_lives_viewRequest', array(
            "result" => $result,
            'liste_BreadcrumbItems' => $this->getBreadcrumbItems(new BreadcrumbItem($result->id))
        ));

    }


    public function refuse($id)
    {
        $this->Lives_model->updateStatus($id, 0);

        $username = $this->Lives_model->getUsernameByLiveId($id);
        setFlashdataMessage($this->session, "La demande du live de " . $username . "a été refusée");
        $this->index();
    }

    public function accept($id)
    {

        $this->Lives_model->updateStatus($id, 2);
        $username = $this->Lives_model->getUsernameByLiveId($id);
        setFlashdataMessage($this->session, "La demande du live de " . $username . "a été acceptée");
        $this->index();


    }

    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueilAdmin(false), new BreadcrumbItem("Lives", "/admin/lives", $current));
    }

    private function getBreadcrumbItems($extra_liste_items)
    {
        if (!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
        return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
    }


}