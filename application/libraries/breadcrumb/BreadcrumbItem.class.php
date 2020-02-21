<?php

/**
 * Gestion des items du fil d'Ariane
 */


class BreadcrumbItem
{
    private $libelle;
    private $link;
    private $active;

    public function __construct($libelle, $link, $active = false)
    {
        $this->libelle = $libelle;
        $this->link = $link;
        $this->active = $active;
    }

    /**
     * Get the value of active
     */
    public function getActive()
    {
        return $this->active ?: false;
    }

    /**
     * Set the value of active
     *
     * @return  self
     */
    public function setActive($active)
    {
        $this->active = $active;

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
}
