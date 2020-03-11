<?php

/**
 * Gestion des items du fil d'Ariane
 */


class BreadcrumbItem
{
    private $libelle;
    private $link;
    private $active;

    public function __construct($libelle, $link = false, $current = false)
    {
        $this->libelle = $libelle;
        $this->link = $link;
        $this->current = $current || !$link;
    }

    /**
     * Get the value of active
     */
    public function getCurrent()
    {
        return $this->current ?: false;
    }

    /**
     * Set the value of active
     *
     * @return  self
     */
    public function setActive($current)
    {
        $this->current = $current;

        return $this;
    }

    /**
     * Get the value of link
     */
    public function getLink()
    {
        return $this->link ?: "#";
    }

    /**
     * Set the value of link
     *
     * @return  self
     */
    public function setLink($link)
    {
        $this->link = $link;

        return $this;
    }

    /**
     * Get the value of libelle
     */
    public function getLibelle()
    {
        return $this->libelle;
    }

    /**
     * Set the value of libelle
     *
     * @return  self
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;

        return $this;
    }

    public static function getBreadcrumbItemAccueil($current = false)
    {
        return new BreadcrumbItem("Accueil","/", $current);
    }

    public static function getBreadcrumbItemAccueilAdmin($current = false)
    {
        return new BreadcrumbItem("Administration", "/admin", $current);
    }
}
