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
     * Fonction de recherche simple
     */
    public function search()
    {
        //Récupération de la chaîne recherchée
        $query = $this->input->post('query', TRUE);
        //Appel à la fonction principale
        $this->search_core($query, false);
    }
    /**
     * Fonction de recherche avancée
     */
    public function searchAvancee()
    {
        //Tableau des critères de recherche
        $json_query = json_decode($this->input->post("json_query", TRUE),true);
        //Appel à la fonction principale
        $this->search_core($json_query, true);
    }

    public function search_core($query, $search_avancee)
    {
        //DAO
        $resultats = $this->podcasts_model->search($query, true, $search_avancee);

        $this->searchstats_model->setQuery($query);
        $this->searchstats_model->insert();

        $this->template->load('search/search', [
            'resultats' => $resultats, 
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true),
            'query' => $query
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
