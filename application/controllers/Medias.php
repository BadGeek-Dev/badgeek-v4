<?php

require_once APPPATH . 'core/Badgeek_Controller.php'; 

class Medias extends Badgeek_Controller 
{
    public function __construct() {
        parent::__construct();
        $this->load->model('podcasts_model');
    }

    /**
     * 
     */
    public function index()
    {
        $podcasts = $this->podcasts_model->findAll();

        $this->template->load('medias/list', ['podcasts' => $podcasts]);
    }

    public function podcast($id)
    {
        $this->load->model('episodes_model');
        $podcast = $this->podcasts_model->findOneById($id);
        $episodes = $this->episodes_model->findByPodcast($podcast);

        $this->template->load('medias/podcast', [
            'podcast' => $podcast,
            'episodes' => $episodes
            ]);
    }

    public function episode($id)
    {
        $this->load->model('episodes_model');
        $episode = $this->episodes_model->findOneById($id);
        $podcast = $this->podcasts_model->findOneById($episode->id_podcast);

        $this->template->load('medias/episode', [
            'episode' => $episode, 
            'podcast' => $podcast
            ]);
    }
}