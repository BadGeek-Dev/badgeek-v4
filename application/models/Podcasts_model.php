<?php

class Podcasts_model extends CI_Model {

    const DB_NAME = "podcasts";

    public $id;
    public $titre;
    public $description;
    public $lien;
    public $image;
    public $rss;
    public $tags;
    public $id_createur;
    public $archive;

    /**
     * 0 waiting validation
     * 1 validated
     * 2 refused 
     */
    const EN_ATTENTE = 0;
    const VALIDE = 1;
    const REFUSE = 2;
    const LIBELLE_EN_ATTENTE = "En attente de validation";
    const LIBELLE_VALIDE = "Validé";
    const LIBELLE_REFUSE = "Refusé";
    
    public $valid;
    public $hosted;

    public function insert()
    {
        $this->db->insert('podcasts', $this);
        $this->id = $this->db->insert_id();
    }

    public function update($podcast)
    {
        $this->db->update('podcasts', $podcast, ['id' => $podcast->id]);
    }

    public function delete($podcast)
    {
        $this->db->delete('podcasts', ['id' => $podcast->id]);
    }

    public function findOneById($id, $return_class = false)
    {
        return $this->db
            ->get_where('podcasts', ['id' => $id, 'archive' => 0])
            ->row(0,get_class($this));
    }

    public function findByUserNotRefused($userId)
    {
        return $this->db->get_where('podcasts', ['id_createur' => $userId, 'valid !=' => self::REFUSE, 'archive' => 0])->result();
    }

    public function findByUser($userId)
    {
     $this->db->select('*');
     $this->db->from('podcasts');
     $this->db->where(['id_createur' => $userId, 'archive' => 0]);
     $query= $this->db->get();
     return $query->result();
    }

    public function findModelsByUser($userId)
    {
     $this->db->select('*');
     $this->db->from('podcasts');
     $this->db->where(['id_createur' => $userId, 'archive' => 0]);
     return $this->db->get()->result(get_class($this));
     
    }

    public function findByUserWaiting($userId)
    {
        return $this->db->get_where('podcasts', ['id_createur' => $userId, 'valid' => self::EN_ATTENTE, 'archive' => 0])->result();
    }

    public function findLastValidated($limit = 5)
    {
        $this->db->select('*');
        $this->db->from('podcasts');
        $this->db->where(['podcasts.valid' =>1, 'podcasts.archive' => 0]);
        $this->db->limit($limit);
        $this->db->order_by('podcasts.id', 'DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function findByValid($valid)
    {
        $this->db->select('podcasts.id, podcasts.description, podcasts.lien, podcasts.titre, users.username, users.email');
        $this->db->from('podcasts');
        $this->db->where(['podcasts.valid' => $valid, 'podcasts.archive' => 0]);
        $this->db->join('users', 'podcasts.id_createur = users.id', 'inner');
        $query = $this->db->get();
        return $query->result();
    }

    public function findAll($exclude_archives = true)
    {
        $this->db->select('podcasts.id, podcasts.description, podcasts.lien, podcasts.titre, podcasts.valid, users.username, users.email');
        $this->db->from('podcasts');
        $this->db->join('users', 'podcasts.id_createur = users.id', 'inner');
        if($exclude_archives) 
        {
            $this->db->where(['podcasts.archive' => 0]);
        }
        $query = $this->db->get();
        return $query->custom_result_object(get_class($this));
    }
        
    /**
     * Fonction de recherche de podcast et d'épisode
     *
     * @param  mixed $query : la requête
     * @param  mixed $exclude_archives : exclure les archives (toujours true pour l'instant)
     * @param  mixed $search_avancee : True si recherche avancée
     * @return array
     */
    public function search($query = null, $exclude_archives = true, $search_avancee = false)
    {
        //Recherche de podcast
        $podcasts = $search_avancee ? $this->searchPodcastAvancee($query) : $this->searchPodcast($query);
        $liste_podcasts = [];
        foreach($podcasts as $podcast)
        {
            $liste_podcasts[$podcast->id] = $podcast;
        }
        //Recherche d'épisode groupés par podcast
        $episodes = $search_avancee ? $this->searchEpisodeAvancee($query) :  $this->searchEpisode($query);
        $liste_episodes = [];
        foreach($episodes as $episode){
            $id_podcast = $episode->podcast_id;
            if(key_exists($id_podcast, $liste_episodes)){
                $liste_episodes[$id_podcast][] = $episode;
            }
            else{
                $liste_episodes[$id_podcast] = [$episode];
            }
        }
        return ["podcasts" =>  $liste_podcasts, 
            "episodes" => $liste_episodes];
    }    
    /**
     * Recherche de podcast
     *
     * @param  mixed $query : Requête
     * @param  mixed $exclude_archives : exclure les archives (toujours true pour l'instant)
     * @return array
     */
    public function searchPodcast($query = null, $exclude_archives = true)
    {
        //Recherche podcast
        $this->db->select('id, description, lien, titre, valid, tags');
        $this->db->from('podcasts');
        $this->db->where('podcasts.valid', 1);
        if($exclude_archives) 
        {
            $this->db->where(['podcasts.archive' => 0]);
        }
        if ($query) {
            $this->db->like('podcasts.titre', $query)
                ->or_like('podcasts.description', $query)
                ->or_where("JSON_SEARCH(`podcasts`.`tags`, 'one', '$query') != ", null);
        }
        $this->db->group_by('podcasts.id');
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Recherche d'épisodes
     *
     * @param  mixed $query : Requête
     * @param  mixed $exclude_archives : exclure les archives (toujours true pour l'instant)
     * @return array
     */
    public function searchEpisode($query = null, $exclude_archives = true)
    {
        //Recherche épisodes
        $this->db->select('episodes.id, episodes.description, episodes.titre, episodes.tags, podcasts.id as podcast_id, podcasts.titre as podcast_titre');
        $this->db->from('episodes');
        $this->db->join('podcasts', 'podcasts.id = episodes.id_podcast', 'left');
        $this->db->where(['episodes.valid' => 1, 'podcasts.valid'=> 1]);
        if($exclude_archives) 
        {
            $this->db->where(['podcasts.archive' => 0]);
        }
        if ($query) {
            $this->db->group_start()
                ->like('episodes.titre', $query)
                ->or_like('episodes.description', $query)
                ->or_where("JSON_SEARCH(`episodes`.`tags`, 'one', '$query') != ", null)
                ->group_end();
        }
        $this->db->group_by('episodes.id');
        $query = $this->db->get();
        return $query->result();
    }

        
    /**
     * Recherche avancée
     *
     * @param  mixed $query : Requête
     * @param  mixed $exclude_archives : exclure les archives (toujours true pour l'instant)
     * @return array
     */
    public function searchAvancee($query = null, $exclude_archives = true)
    {
        return $this->search($query, true , true);
    }
        
    /**
     * Recherche avancée de podcast
     *
     * @param  mixed $query : Requête
     * @param  mixed $exclude_archives : exclure les archives (toujours true pour l'instant)
     * @return array
     */
    public function searchPodcastAvancee($query = null, $exclude_archives = true)
    {
        //Recherche podcast
        $this->db->select('id, description, lien, titre, valid, tags');
        $this->db->from('podcasts');
        $this->db->where('podcasts.valid', 1);
        if($exclude_archives) 
        {
            $this->db->where(['podcasts.archive' => 0]);
        }
        if ($query) {
            $this->db->group_start();
            $this->db->where("1");
            foreach($query as $key => $values)
            {
                foreach($values as $value)
                {
                    if($key == "tags")
                    {
                        $this->db->or_where("JSON_SEARCH(`podcasts`.`tags`, 'one', '$value') != ", null);
                    }
                    else
                    {
                        $this->db->or_like("podcasts.$key", $value);
                    }
                }
            }
            $this->db->group_end();
        }
        $this->db->group_by('podcasts.id');
        $query = $this->db->get();
        return $query->result();
    }
    
    /**
     * Recherche avancée d'épisodes 
     *
    * @param  mixed $query : Requête
     * @param  mixed $exclude_archives : exclure les archives (toujours true pour l'instant)
     * @return void array
     */
    public function searchEpisodeAvancee($query = null, $exclude_archives = true)
    {
        //Recherche épisodes
        $this->db->select('episodes.id, episodes.description, episodes.titre, episodes.tags, podcasts.id as podcast_id, podcasts.titre as podcast_titre');
        $this->db->from('episodes');
        $this->db->join('podcasts', 'podcasts.id = episodes.id_podcast', 'left');
        $this->db->where(['episodes.valid' => 1, 'podcasts.valid'=> 1]);
        if($exclude_archives) 
        {
            $this->db->where(['podcasts.archive' => 0]);
        }
        if ($query) {
            $this->db->group_start();
            $this->db->where("1");
            foreach($query as $key => $values)
            {
                foreach($values as $value)
                {
                    if($key == "tags")
                    {
                        $this->db->or_where("JSON_SEARCH(`episodes`.`tags`, 'one', '$value') != ", null);
                    }
                    else
                    {
                        $this->db->or_like("episodes.$key", $value);
                    }
                }
            }
            $this->db->group_end();
        }
        $this->db->group_by('episodes.id');
        $query = $this->db->get();
        return $query->result();
    }

    public function findAllValid()
    {
        return $this->db->get_where('podcasts', ['valid' => 1])->result();
    }

    public function findByContainRss()
    {
        return $this->db->select('*')
            ->from('podcasts')
            ->where('rss !=', null)
            ->get()
            ->result();
    }

    public function findByTitre($query)
    {
        return $this->db->select('*')
            ->from('podcasts')
            ->like('titre', $query)
            ->get()
            ->result();   
    }

    public function archiveByUser($id_createur)
    {
        $this->db->update(self::DB_NAME, ["archive" => 1], "id_createur='$id_createur'");
    }

    public function unarchiveByUser($id_createur)
    {
        $this->db->update(self::DB_NAME, ["archive" => 0], "id_createur='$id_createur'");
    }

    public function isEnAttente()
    {
        return $this->valid == self::EN_ATTENTE;
    }
    public function isValide()
    {
        return $this->valid == self::VALIDE;
    }
    public function isRefuse()
    {
        return $this->valid == self::REFUSE;
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

    /**
     * Get the value of valid
     */ 
    public function getValid()
    {
        return $this->valid;
    }

    /**
     * Set the value of valid
     *
     * @return  self
     */ 
    public function setValid($valid)
    {
        $this->valid = $valid;

        return $this;
    }

    /**
     * Get the value of hosted
     */ 
    public function getHosted()
    {
        return $this->hosted;
    }

    /**
     * Set the value of hosted
     *
     * @return  self
     */ 
    public function setHosted($hosted)
    {
        $this->hosted = $hosted;

        return $this;
    }
}
