<?php

require_once APPPATH . 'core/Badgeek_Controller.php'; 

class User extends Badgeek_Controller 
{
    public function __construct()
    {
        parent::__construct();

        if (!$this->ion_auth->logged_in()) {
            redirect('badgeek/index');
        }
    }

    /**
     * 
     */
    public function index()
    {
        
        $this->template->load('user/pref', [
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true)
        ]);
    }

    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueil(), new BreadcrumbItem("Utilisateur", "/utilisateur", $current));
    }

    private function getBreadcrumbItems($extra_liste_items)
    {
        if(!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
        return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
    }
}