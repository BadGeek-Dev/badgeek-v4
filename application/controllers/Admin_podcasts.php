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

    public function waiting()
    {
        $podcasts = $this->podcasts_model->findByValid(0);

        $this->template->load_admin('admin/podcasts_waiting', ['podcasts' => $podcasts]);
    }

    public function validate($id)
    {
        $podcast = $this->podcasts_model->findOneById($id);

        if ($podcast) {
            $podcast->valid = 1;
            $this->podcasts_model->update($podcast);
        }

        redirect('/admin/podcasts/waiting');
    }

    public function delete($id)
    {
        $podcast = $this->podcasts_model->findOneById($id);

        if ($podcast) {
            $this->load->model('episodes_model');
            $this->episodes_model->deleteByPodcast($podcast);
            $this->podcasts_model->delete($podcast);
        }

        redirect('/admin/podcasts/waiting');
    }
}