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
        $query = $this->input->get('query', TRUE);

        $podcasts = $this->podcasts_model->search($query);

        $this->searchstats_model->setQuery($query);
        $this->searchstats_model->insert();

        $this->template->load('search/search', [
            'podcasts' => $podcasts, 
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true)
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
