<?php

require_once APPPATH . 'core/Badgeek_Controller.php';

class Admin_podcasts extends Badgeek_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->checkAdminRights();

        $this->load->model('podcasts_model');
    }

    public function index()
    {
        $podcasts = $this->podcasts_model->findAll();

        $this->template->load_admin('admin/podcasts', ['podcasts' => $podcasts, 'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true)]);
    }

    public function validate($id)
    {
        $podcast = $this->podcasts_model->findOneById($id);
        $this->load->model('users_model');
        $creator = $this->users_model->findOneById($podcast->id_createur);

        if ($podcast) {
            $podcast->valid = Podcasts_model::VALIDE;
            $this->podcasts_model->update($podcast);

            $this->load->library('email_manager');
            $this->email_manager->sendPodcastValidatedEmail($podcast, $creator);
        }

        redirect('/admin/podcasts');
    }

    public function rewaiting($id)
    {
        $podcast = $this->podcasts_model->findOneById($id);
        $this->load->model('users_model');
        $creator = $this->users_model->findOneById($podcast->id_createur);

        if ($podcast) 
        {
            $podcast->valid = Podcasts_model::EN_ATTENTE;
            $this->podcasts_model->update($podcast);
            $this->load->library('email_manager');
            $this->email_manager->sendValidationPodcastEmail($podcast, $creator);
        }

        redirect('/admin/podcasts');
    }

    public function view($id)
    {
        $podcast = $this->podcasts_model->findOneById($id);
        $this->load->model('users_model');
        $creator = $this->users_model->findOneById($podcast->id_createur);

        $this->template->load_admin('admin/podcasts_view', ['podcast' => $podcast, 'creator' => $creator, 
        'liste_BreadcrumbItems' => $this->getBreadcrumbItems(new BreadcrumbItem($podcast->titre))]);
    }

    public function refuse($id)
    {
        $podcast = $this->podcasts_model->findOneById($id);
        $this->load->model('users_model');
        $creator = $this->users_model->findOneById($podcast->id_createur);

        if ($podcast) {
            $podcast->valid = Podcasts_model::REFUSE;
            $this->podcasts_model->update($podcast);

            $this->load->library('email_manager');
            $this->email_manager->sendPodcastRefusedEmail($podcast, $creator, $this->input->post('reason'));
        }

        redirect('/admin/podcasts');
    }

    public function delete($id)
    {
        $podcast = $this->podcasts_model->findOneById($id);

        if ($podcast) {
            $this->load->model('episodes_model');
            $this->episodes_model->deleteByPodcast($podcast);
            $this->podcasts_model->delete($podcast);
        }

        redirect('/admin/podcasts');
    }

    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueilAdmin(false), new BreadcrumbItem("Gestion des podcasts","/admin/podcasts", $current));
    }

    private function getBreadcrumbItems($extra_liste_items)
    {
        if(!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
        return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
    }
}