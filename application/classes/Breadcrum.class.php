<?php

/**
 * Gestion du fil d'Ariane
 */

namespace Badgeek;

use Badgeek;
use Exception;

require_once __DIR__."/BreadcrumItem.class.php";

class Breadcrumb 
{
    private $liste_items = array();

    public function __construct($liste_items = array())
    {
        //On filtre les objets de type non BreadcrumItem
        $this->setListe_items($liste_items);
    }

    public function __toString()
    {
        $return = "";
        if(count($this->getListe_items()))
        {
            $return .= '
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
        }
    }
    /**
     * Ajoute un item à la liste
     *
     * @param BreadcrumItem $item
     * @return void
     */
    public function addItem(BreadcrumItem $item)
    {
        array_push($this->getListe_items(), $item);
    }

    /**
     * Liste d'items
     *
     * @return Badgeek\BreadcrumItem[]
     */
    public function getListe_items()
    {
        return $this->liste_items;
    }

    /**
     * Met la liste d'items Ã  jour.
     *
     * @param array $liste_items
     * @return Badgeek\Breadcrum
     */
    public function setListe_items(array $liste_items)
    {
        $this->liste_items = array_filter($liste_items, function ($item) {
            return is_a($item, "BreadcrumItem");
        });

        return $this;
    }

    public static function constructFromControllerFunction($controller, $function)
    {
        $breadcrumb = new self();
    }
}
