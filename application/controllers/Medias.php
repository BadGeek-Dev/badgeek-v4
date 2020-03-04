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
        $this->template->load('medias/list', [
            'podcasts' => $podcasts, 
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true)
        ]);
    }

    public function podcast($id)
    {
        $this->load->model('episodes_model');
        $podcast = $this->podcasts_model->findOneById($id);
        $episodes = $this->episodes_model->findByPodcast($podcast);

        $this->template->load('medias/podcast', [
            'podcast' => $podcast,
            'episodes' => $episodes,
            'liste_BreadcrumbItems' => $this->getBreadcrumbItems(new BreadcrumbItem($podcast->titre))
        ]);
    }

    public function episode($id)
    {
        $this->load->model('episodes_model');
        $episode = $this->episodes_model->findOneById($id);
        $podcast = $this->podcasts_model->findOneById($episode->id_podcast);

        $this->template->load('medias/episode', [
            'episode' => $episode, 
            'podcast' => $podcast,
            'liste_BreadcrumbItems' => $this->getBreadcrumbItems(new BreadcrumbItem($podcast->titre. " - Episode '".$episode->titre."'"))
        ]);
    }

    public function search($query)
    {
        $podcasts = $this->podcasts_model->findByTitre($query);
        $this->template->load('medias/search', [
            'podcasts' => $podcasts, 
            'query' => $query,
            'liste_BreadcrumbItems' => $this->getBreadcrumbItems(new BreadcrumbItem("Recherche de '$query"))
        ]);
    }

    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueil(), new BreadcrumbItem("Les podcasts", "/medias", $current));
    }

    private function getBreadcrumbItems($extra_liste_items)
    {
        if(!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
        return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
    }
}