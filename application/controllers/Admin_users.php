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

        if ($this->ion_auth->is_admin($user->id))
        {
            redirect('/admin/users');
        }
        $this->load->helper("form");
        $this->template->load_admin('admin/users_edit', array(
            "user" => $user,
            "liste_podcasts" => $this->podcasts_model->findByUserNotRefused($user->id),
            'liste_BreadcrumbItems' => $this->getBreadcrumbItems(new BreadcrumbItem(getLibelleFromUser($user)))
        ));
    }

    public function activate($id)
    {
        $this->changeActiveState($id, Users_Model::ACTIVE);
    }

    public function deactivate($id)
    {
        $this->changeActiveState($id, Users_Model::DESACTIVE, $this->input->post('motif'));
    }

    public function unvalidate($id)
    {
        $this->changeActiveState($id, Users_Model::NON_VALIDE);
    }

    private function changeActiveState($id, $state, $motif= "")
    {
        $user = $this->Users_model->bareFindOneById($id);
        $user->active = $state;
        $this->Users_model->update($user);

        $this->load->library('email_manager');
        $this->email_manager->sendUserActiveState($user, $state, $motif);
        
        //Si on désactive un compte, on archive ses podcasts
        //Si on l'active, on les désarchive.
        if($state == Users_Model::DESACTIVE)
        {
            $this->podcasts_model->archiveByUser($id);
        }
        else if($state == Users_Model::ACTIVE)
        {
            $this->podcasts_model->unarchiveByUser($id);
        }

        redirect('/admin/users/edit/'.$id);
    }

    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueilAdmin(false), new BreadcrumbItem("Gestions des utilisateurs","/admin/users", $current));
    }

    private function getBreadcrumbItems($extra_liste_items)
    {
        if(!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
        return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
    }
}