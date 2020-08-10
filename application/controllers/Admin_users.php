<?php

require_once APPPATH . 'core/Badgeek_Controller.php';

class Admin_users extends Badgeek_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->checkAdminRights();
        $this->load->model('Users_model');
    }

    public function index()
    {
        $users = $this->Users_model->getAllUsers();
        $this->template->load_admin('admin/users', array(
            "users" => $users,
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true)
        ));
    }

    public function edit($id)
    {
        $user = $this->Users_model->findOneById($id);
        $this->template->load_admin('admin/users_edit', array(
            "user" => $user,
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true)
        ));
    }

    public function activate($id)
    {
        $this->changeActiveState($id, 1);
    }

    public function deactivate($id)
    {
        $this->changeActiveState($id, 0);
    }

    private function changeActiveState($id, $state)
    {
        $user = $this->Users_model->bareFindOneById($id);
        $user->active = $state;
        $this->Users_model->update($user);

        redirect('/admin/users/edit/'.$id);
    }

    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueilAdmin(false), new BreadcrumbItem("Articles","/admin/users", $current));
    }

    private function getBreadcrumbItems($extra_liste_items)
    {
        if(!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
        return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
    }
}