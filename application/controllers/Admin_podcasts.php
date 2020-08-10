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

        $this->template->load_admin('admin/podcasts', ['podcasts' => $podcasts]);
    }

    public function validate($id)
    {
        $podcast = $this->podcasts_model->findOneById($id);
        $this->load->model('users_model');
        $creator = $this->users_model->findOneById($podcast->id_createur);

        if ($podcast) {
            $podcast->valid = 1;
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
            $podcast->valid = 0;
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

        $this->template->load_admin('admin/podcasts_view', ['podcast' => $podcast, 'creator' => $creator]);
    }

    public function refuse($id)
    {
        $podcast = $this->podcasts_model->findOneById($id);
        $this->load->model('users_model');
        $creator = $this->users_model->findOneById($podcast->id_createur);

        if ($podcast) {
            $podcast->valid = 2;
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
}