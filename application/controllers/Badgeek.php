<?php

require_once APPPATH . 'core/Badgeek_Controller.php'; 

class Badgeek extends Badgeek_Controller
{
    public function index()
    {
        $this->load->model('Articles_model');
        $this->load->model('Podcasts_model');
        $this->load->model('Episodes_model');

        $this->template->load(
            'public/index', 
            [
                "result" => $this->Articles_model->getAllArticlesVisible(),
                "podcasts" => $this->Podcasts_model->findLastValidated(),
                "episodes" => $this->Episodes_model->findLastValidated(),
                "liste_BreadcrumbItems" => [
                    BreadcrumbItem::getBreadcrumbItemAccueil(true)
                    ]
            ]);
    }
}
