<?php if (!defined('BASEPATH')) exit("No direct script access allowed");

class Task extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->input->is_cli_request() 
            or redirect('/');
    }

    /**
     * call with php index.php podcast_sync
     */
    public function podcast_sync()
    {
        $this->load->model('podcasts_model');
        $this->load->library('rss_import');
        
        $podcasts = $this->podcasts_model->findByContainRss();
        echo 'Synchronisation de '.count($podcasts)." podcast(s) \n";
        foreach ($podcasts as $podcast) {
            echo $podcast->titre.' : '.$this->rss_import->sync($podcast)." épisode(s) ajouté(s) \n";
        }
        echo 'Fini';
    }
}