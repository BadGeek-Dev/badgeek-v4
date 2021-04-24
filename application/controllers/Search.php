<?php

require_once APPPATH . 'core/Badgeek_Controller.php'; 

class Search extends Badgeek_Controller 
{
    public function __construct() {
        parent::__construct();
        $this->load->model('podcasts_model');
        $this->load->model('searchstats_model');
    }

    /**
     * 
     */
    public function index()
    {
        $query = $this->input->post('query', TRUE);

        $podcasts = $this->podcasts_model->search($query);

        $this->searchstats_model->setQuery($query);
        $this->searchstats_model->insert();

        $this->template->load('search/search', [
            'podcasts' => $podcasts, 
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true),
            'query' => $query
            ]);
    }

    public function rechercheAvancee()
    {
        $json_query = json_decode($this->input->post("json_query", TRUE),true);
        $podcasts = $this->podcasts_model->searchAvancee($json_query);

        $this->searchstats_model->setQuery($json_query);
        $this->searchstats_model->insert();

        $this->template->load('search/search', [
            'podcasts' => $podcasts, 
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true),
            'query' => ""
            ]);

    }

    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueil(), new BreadcrumbItem("Recherche", "/recherche", $current));
    }

    private function getBreadcrumbItems($extra_liste_items)
    {
        if(!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
        return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
    }
}
