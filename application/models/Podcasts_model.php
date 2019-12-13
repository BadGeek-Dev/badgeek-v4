<?php

class Podcasts_model extends CI_Model {

    public $id;
    public $titre;
    public $description;
    public $lien;
    public $image;
    public $rss;
    public $tags;
    public $id_createur;

    public function insert()
    {
        $this->db->insert('podcasts', $this);
    }

    public function update()
    {
        $this->db->update('podcasts', $this, ['id' => $this->id]);
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of titre
     */ 
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * Set the value of titre
     *
     * @return  self
     */ 
    public function setTitre($titre)
    {
        $this->titre = $titre;

        return $this;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of lien
     */ 
    public function getLien()
    {
        return $this->lien;
    }

    /**
     * Set the value of lien
     *
     * @return  self
     */ 
    public function setLien($lien)
    {
        $this->lien = $lien;

        return $this;
    }

    /**
     * Get the value of image
     */ 
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of image
     *
     * @return  self
     */ 
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of rss
     */ 
    public function getRss()
    {
        return $this->rss;
    }

    /**
     * Set the value of rss
     *
     * @return  self
     */ 
    public function setRss($rss)
    {
        $this->rss = $rss;

        return $this;
    }

    /**
     * Get the value of tags
     */ 
    public function getTags()
    {
        return $this->tags;
    }

    /**
     * Set the value of tags
     *
     * @return  self
     */ 
    public function setTags($tags)
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * Get the value of id_createur
     */ 
    public function getId_createur()
    {
        return $this->id_createur;
    }

    /**
     * Set the value of id_createur
     *
     * @return  self
     */ 
    public function setId_createur($id_createur)
    {
        $this->id_createur = $id_createur;

        return $this;
    }
}