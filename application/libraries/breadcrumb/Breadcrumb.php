<?php

/**
 * Gestion du fil d'Ariane
 */

require_once __DIR__."/BreadcrumbItem.class.php";

class Breadcrumb 
{
    private $liste_items = array();

    public function __construct($liste_items = array())
    {
        //On filtre les objets de type non BreadcrumbItem
        $this->setListe_items($liste_items);
    }

    public function __toString()
    {
        if(count($this->getListe_items()) == 0) return "";
        
        $return = '
            <nav aria-label="breadcrumb" aria-current="page">
                <ol class="breadcrumb">';
        foreach ($this->getListe_items() as $item) {
            if($item->getActive())
            {
                $return .= '<li class="breadcrumb-item active" aria-current="page">'.$item->getLibelle().'</li>';
            }
            else 
            {
                $return .= '<li class="breadcrumb-item"><a href="'.$item->getLink().'">'.$item->getLibelle().'</a></li>';
            }
        }
        $return .='
                </ol>
            </nav>';
        return $return;
    }
    /**
     * Ajoute un item � la liste
     *
     * @param BreadcrumbItem $item
     * @return void
     */
    public function addItem(BreadcrumbItem $item)
    {
        $liste_item = $this->getListe_items();
        array_push($liste_item, $item);
        $this->setListe_items($liste_item);
        return $this;
    }

    public function addItems(array $items)
    {
        $items = array_filter($items, function ($item) {
            return is_a($item, "BreadcrumbItem");
        });
        foreach($items as $item) $this->addItem($item);
        return $this;
    }
    

    /**
     * Liste d'items
     *
     * @return BreadcrumbItem[]
     */
    public function getListe_items()
    {
        return $this->liste_items;
    }

    /**
     * Met la liste d'items à jour.
     *
     * @param array $liste_items
     * @return Breadcrum
     */
    public function setListe_items(array $liste_items)
    {
        $this->liste_items = array_filter($liste_items, function ($item) {
            return is_a($item, "BreadcrumbItem");
        });
        return $this;
    }

    public static function constructFromCaller($caller, $extras = array())
    {
        return self::constructFromControllerFunction($caller['class'],$caller['function'], $extras);
    }

    public static function constructFromControllerFunction($controller, $function = "", $extras = array())
    {
        $breadcrumb = new self();
        $item_accueil = new BreadcrumbItem("Accueil","/");
        switch ($controller) {
            case 'Admin':
                $breadcrumb->addItem(new BreadcrumbItem("Administration", "/admin", $function == 'index'));
                switch ($function) {
                    case 'addArticle':
                        $breadcrumb->addItem(new BreadcrumbItem("Ecrire un nouvel article"));
                        break;
                    case 'editArticle':
                        $breadcrumb->addItem(new BreadcrumbItem("Editer un article"));
                        break;
                    default:
                        break;
                }
                break;
            case 'Badgeek':
                $breadcrumb->addItem($item_accueil->setActive(true));
                break;
            case 'Podcasts':
                $breadcrumb->addItems(array($item_accueil, new BreadcrumbItem("Mes podcasts", "/".$controller, $function == "index")));
                switch ($function) {
                    case 'create':
                        $breadcrumb->addItem(new BreadcrumbItem("Ajouter un podcast"));
                        break;
                    case 'edit':
                        $libelle_breadcrumb = key_exists("podcast_name", $extras) ? $extras["podcast_name"] : false;
                        $breadcrumb->addItem(new BreadcrumbItem($libelle_breadcrumb ?: "Gérer le podcast"));
                        break;
                    default:
                        break;
                }
                break;
            default:
                $breadcrumb->addItem($item_accueil->setActive(true));
                break;
        }
        return $breadcrumb;
    }
}
