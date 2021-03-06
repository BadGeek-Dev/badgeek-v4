<?php

require_once APPPATH . 'core/Badgeek_Controller.php'; 

class Podcasts extends Badgeek_Controller 
{
    public function __construct() {
        parent::__construct();
        $this->load->model('podcasts_model');
        $this->load->model('episodes_model');
    }

    /**
     * 
     */
    public function create()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('badgeek/index');
        }

        $this->load->helper(['form', 'url']);
        $this->load->library('form_validation');

        $config = [
            [
                'field' => 'titre',
                'label' => 'Nom du podcast',
                'rules' => 'required',
            ],
            [
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'required',
            ],
            [
                'field' => 'lien',
                'label' => 'Lien',
                'rules' => 'callback_real_url',
                'errors' => [
                    'real_url' => 'Lien non accessible',
                ],
            ],
        ];

        if (!$this->input->post('hosted')) {
            $config[] = [
                'field' => 'rss',
                'label' => 'Rss',
                'rules' => 'required|callback_real_url',
                'errors' => [
                    'real_url' => 'Rss non accessible',
                ],
            ];
        }

        $this->form_validation->set_rules($config);

        if (false === $this->form_validation->run()) {
            
        } else {
            $this->podcasts_model->setTitre($this->input->post('titre'));
            $this->podcasts_model->setDescription($this->input->post('description'));
            $this->podcasts_model->setLien($this->input->post('lien'));
            $this->podcasts_model->setImage($this->input->post('image'));
            $this->podcasts_model->setRss($this->input->post('rss'));
            $this->podcasts_model->setTags($this->input->post('tags'));
            $this->podcasts_model->setHosted($this->input->post('hosted'));
            $this->podcasts_model->setId_createur($this->user->id);
            $this->podcasts_model->setValid(Podcasts_model::EN_ATTENTE);

            $this->podcasts_model->insert();

            $this->load->library('email_manager');
            $this->email_manager->sendValidationPodcastEmail($this->podcasts_model, $this->user);

            redirect('podcasts/create/'.$this->podcasts_model->getId());
        }

        $attributes = [
            [
                'type' => 'checkbox',
                'name' => 'hosted',
                'id' => 'hosted',
                'label' => 'Podcast hébergé chez BadGeek ?',
                'class' => 'form-control hosted',
                'value' => true
            ],
            [        
                'type' => 'text',
                'name' => 'titre',
                'id' => 'titre',
                'label' => 'Nom du podcast *',
                'class' => 'form-control',
                'required' => true,
                'value' => $this->input->post('titre'),
                'maxlength' => 100,
            ],
            [        
                'type' => 'text',
                'name' => 'description',
                'id' => 'description',
                'label' => 'Description *',
                'class' => 'form-control',
                'required' => true,
                'value' => $this->input->post('description'),
                'maxlength' => 100,
            ],
            [        
                'type' => 'text',
                'name' => 'lien',
                'id' => 'lien',
                'label' => 'Site internet',
                'class' => 'form-control',
                'value' => $this->input->post('lien'),
                'maxlength' => 100,
            ],
            [        
                'type' => 'text',
                'name' => 'image',
                'id' => 'image',
                'label' => 'Logo',
                'class' => 'form-control',
                'value' => $this->input->post('image'),
                'maxlength' => 100,
            ],
            [        
                'type' => 'text',
                'name' => 'rss',
                'id' => 'rss',
                'label' => 'Flux rss *',
                'class' => 'form-control rss',
                'value' => $this->input->post('rss'),
                'maxlength' => 100,
            ],
            [        
                'type' => 'text',
                'name' => 'tags',
                'id' => 'tags',
                'label' => 'Nuage de tags',
                'class' => 'form-control',
                'value' => $this->input->post('tags'),
                'maxlength' => 100,
            ],
        ];

        $this->template->load('podcasts/create', [
            'attributes' => $attributes, 
            'liste_BreadcrumbItems' => $this->getBreadcrumbItems(new BreadcrumbItem("Ajouter un podcast"))
        ]);
    }

    /**
     * 
     */
    public function createWaitingValidation($id)
    {
        $podcast = $this->podcasts_model->findOneById($id);

        $this->template->load('podcasts/waiting_validation', [
            'podcast' => $podcast, 
            'liste_BreadcrumbItems' => $this->getBreadcrumbItems(new BreadcrumbItem("Podcast en cours de validation"))
        ]);
    }

    /**
     * 
     */
    public function index()
    {
        $podcasts_waiting = $this->user ? $this->podcasts_model->findByUserWaiting($this->user->id) : [];
        $podcasts = $this->podcasts_model->findByValid(Podcasts_model::VALIDE);

        $this->template->load('podcasts/list', [
            'podcasts_waiting' => $podcasts_waiting,
            'podcasts' => $podcasts, 
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true)
            ]);
    }
    
	public function indexPodcasteur()
	{

		checkIsPodcasteur();
		$podcasts = $this->podcasts_model->findModelsByUser($this->user->id);
		foreach ($podcasts as $podcast){
			$nbep = count($this->episodes_model->findByPodcast($podcast));
			$podcast->nombreEpisodes = $nbep;
            $podcast->badge_statut = getBadgeFromPodcast($podcast);
            $podcast->tags_value = "";
            $tags_value = json_decode($podcast->tags);
            if($tags_value)
            {
                foreach($tags_value as $tag_value)
                {
                    $podcast->tags_value .= $tag_value->value.",";
                }
                $podcast->tags_value = substr($podcast->tags_value, 0, -1);
            }
		}

		$this->template->load('podcasts/podcasteurList', [
			'podcasts' => $podcasts,
			'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true)
		]);
	}
        
    /**
     * Affichage de la fiche d'un podcast
     *
     * @param  mixed $id id du podcast
     * @return void
     */
    public function display($id)
    {
        $this->load->model('episodes_model');
        $podcast = $this->podcasts_model->findOneById($id);
        if($podcast)
        {
            //On vérifie le statut du podcast
            switch ($podcast->valid) 
            {
                case Podcasts_model::EN_ATTENTE:
                    $this->template->loadError($this->getErrorMessage("podcast_en_attente"));
                    break;
                case Podcasts_model::VALIDE:
                    $episodes = $this->episodes_model->findByPodcast($podcast);
                    $this->template->load('podcasts/display', [
                        'podcast' => $podcast,
                        'episodes' => $episodes,
                        'liste_BreadcrumbItems' => $this->getBreadcrumbItems(new BreadcrumbItem($podcast->titre))
                    ]);
                    break;
                case Podcasts_model::REFUSE:
                    $this->template->loadError($this->getErrorMessage("podcast_inexistant"));
                    break;
            }
            
        }
        else
        {
            //Podcast non trouvé
            $this->template->loadError($this->getErrorMessage("podcast_inexistant"));
        }
        
    }

    public function edit($id)
    {
        $this->load->model('episodes_model');
        $podcast = $this->podcasts_model->findOneById($id);

        if ($podcast->id_createur != $this->user->id){
            redirect('/');
        }

        $this->load->helper(['form', 'url']);
        $this->load->library('form_validation');

        $config = [
            [
                'field' => 'titre',
                'label' => 'Nom du podcast',
                'rules' => 'required',
            ],
            [
                'field' => 'description',
                'label' => 'Description',
                'rules' => 'required',
            ],
            [
                'field' => 'lien',
                'label' => 'Lien',
                'rules' => 'callback_real_url',
                'errors' => [
                    'real_url' => 'Lien non accessible',
                ],
            ],
        ];

        $this->form_validation->set_rules($config);

        if (false === $this->form_validation->run()) {
            
        } else {
            $podcast->titre = $this->input->post('titre');
            $podcast->description = $this->input->post('description');
            $podcast->lien = $this->input->post('lien');
            $podcast->image = $this->input->post('image');
            $podcast->tags = $this->input->post('tags');
            $podcast->valid = Podcasts_model::EN_ATTENTE;

            $this->podcasts_model->update($podcast);
            redirect('podcasts/create/'.$podcast->id);
        }

        $attributes = [
            [        
                'type' => 'text',
                'name' => 'titre',
                'id' => 'titre',
                'label' => 'Nom du podcast *',
                'class' => 'form-control',
                'required' => true,
                'value' => $podcast->titre,
                'maxlength' => 100,
            ],
            [        
                'type' => 'text',
                'name' => 'description',
                'id' => 'description',
                'label' => 'Description *',
                'class' => 'form-control',
                'required' => true,
                'value' => $podcast->description,
                'maxlength' => 100,
            ],
            [        
                'type' => 'text',
                'name' => 'lien',
                'id' => 'lien',
                'label' => 'Site internet',
                'class' => 'form-control',
                'value' => $podcast->lien,
                'maxlength' => 100,
            ],
            [        
                'type' => 'text',
                'name' => 'image',
                'id' => 'image',
                'label' => 'Logo',
                'class' => 'form-control',
                'value' => $podcast->image,
                'maxlength' => 100,
            ],
            [        
                'type' => 'text',
                'name' => 'tags',
                'id' => 'tags',
                'label' => 'Nuage de tags',
                'class' => 'form-control',
                'value' => $podcast->tags,
                'maxlength' => 100,
            ],
        ];

        $this->template->load('podcasts/edit', [
            'podcast' => $podcast,
            'attributes' => $attributes
        ]);
    }

    public function delete($id)
    {
        $podcast = $this->podcasts_model->findOneById($id);

        if ($this->user->id == $podcast->id_createur) {
            $this->load->model('episodes_model');
            $this->episodes_model->deleteByPodcast($podcast);
            $this->podcasts_model->delete($podcast);
        }

        redirect('/podcasts');
    }

    /**
     *
     */
    public function sync($id)
    {
        $podcast = $this->podcasts_model->findOneById($id);

        $this->load->library('rss_import');
        $this->rss_import->sync($podcast);

        redirect('/podcasts/display/'.$podcast->id);
    }

    public function mp3($dir, $file)
    {
        $this->load->helper('file');

        $mp3Path = APPPATH.'../uploads/podcasts/'.$dir.'/'.$file;
        $this->output->set_content_type(get_mime_by_extension($mp3Path));
        $this->output->set_output(file_get_contents($mp3Path));
    }

    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueil(), new BreadcrumbItem("Podcasts", "/podcasts", $current));
    }

    private function getBreadcrumbItems($extra_liste_items)
    {
        if(!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
        return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
    }
}
