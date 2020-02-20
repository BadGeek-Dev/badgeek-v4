<?php

/**
 * Gestion du fil d'Ariane
 */

namespace Badgeek;

use Badgeek;

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
            <nav aria-label="breadcrumb">aria-current="page"
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
        array_push($this->getListe_items(), $item);
    }

    /**
     * Liste d'items
     *
     * @return Badgeek\BreadcrumbItem[]
     */
    public function getListe_items()
    {
        return $this->liste_items;
    }

    /**
     * Met la liste d'items à jour.
     *
     * @param array $liste_items
     * @return Badgeek\Breadcrum
     */
    public function setListe_items(array $liste_items)
    {
        $this->liste_items = array_filter($liste_items, function ($item) {
            return is_a($item, "BreadcrumbItem");
        });

        return $this;
    }

    public static function constructFromControllerFunction($controller, $function)
    {
        $breadcrumb = new self();
    }
}
