<?php

class Episodes_model extends CI_Model {

    public $id;
    public $numero;
    public $titre;
    public $description;
    public $date_publication;
    public $lien_mp3;
    public $infos_mp3;
    public $tags;
    public $id_podcast;

    public function refresh()
    {
        $this->id = null;
        $this->numero = null;
        $this->titre = null;
        $this->description = null;
        $this->date_publication = null;
        $this->lien_mp3 = null;
        $this->infos_mp3 = null;
        $this->tags = null;
        $this->id_podcast = null;
    }

    public function insert()
    {
        $this->db->insert('episodes', $this);
        $this->id = $this->db->insert_id();
    }

    public function update($episode)
    {
        $this->db->update('episodes', $episodes, ['id' => $episode->id]);
    }

    public function deleteByPodcast($podcast)
    {
        $this->db->where('id_podcast', $podcast->id);
        $this->db->delete('episodes');
    }

    public function delete($episode)
    {
        $this->db->delete('episodes', ['id' => $episode->id]);
    }

    public function findOneById($id)
    {
        return $this->db->get_where('episodes', ['id' => $id])->row();
    }

    public function findByPodcast($podcast)
    {
        return $this->db
            ->where('id_podcast', $podcast->id)
            ->order_by('date_publication')
            ->get('episodes')
            ->result();
    }

    public function findLastByPodcast($podcast)
    {
        return $this->db
            ->where('id_podcast', $podcast->id)
            ->order_by('id', 'DESC')
            ->get('episodes')
            ->row();
    }
    
    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of numero
     */ 
    public function getNumero()
    {
        return $this->numero;
    }

    /**
     * Set the value of numero
     *
     * @return  self
     */ 
    public function setNumero($numero)
    {
        $this->numero = $numero;

        return $this;
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
     * Get the value of date_publication
     */ 
    public function getDate_publication()
    {
        return $this->date_publication;
    }

    /**
     * Set the value of date_publication
     *
     * @return  self
     */ 
    public function setDate_publication($date_publication)
    {
        $this->date_publication = $date_publication;

        return $this;
    }

    /**
     * Get the value of lien_mp3
     */ 
    public function getLien_mp3()
    {
        return $this->lien_mp3;
    }

    /**
     * Set the value of lien_mp3
     *
     * @return  self
     */ 
    public function setLien_mp3($lien_mp3)
    {
        $this->lien_mp3 = $lien_mp3;

        return $this;
    }

    /**
     * Get the value of infos_mp3
     */ 
    public function getInfos_mp3()
    {
        return $this->infos_mp3;
    }

    /**
     * Set the value of infos_mp3
     *
     * @return  self
     */ 
    public function setInfos_mp3($infos_mp3)
    {
        $this->infos_mp3 = $infos_mp3;

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
     * Get the value of id_podcast
     */ 
    public function getId_podcast()
    {
        return $this->id_podcast;
    }

    /**
     * Set the value of id_podcast
     *
     * @return  self
     */ 
    public function setId_podcast($id_podcast)
    {
        $this->id_podcast = $id_podcast;

        return $this;
    }
}