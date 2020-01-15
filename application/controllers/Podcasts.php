<?php

require_once APPPATH . 'core/Badgeek_Controller.php'; 

class Podcasts extends Badgeek_Controller 
{
    /**
     * 
     */
    public function create()
    {
        if (!$this->ion_auth->logged_in()) {
            redirect('badgeek/index');
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('titre', 'Nom du podcast', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if (false === $this->form_validation->run()) {
            
        } else {
            $this->load->model('podcasts_model');
            $this->podcasts_model->setTitre($this->input->post('titre'));
            $this->podcasts_model->setDescription($this->input->post('description'));
            $this->podcasts_model->setLien($this->input->post('lien'));
            $this->podcasts_model->setImage($this->input->post('image'));
            $this->podcasts_model->setRss($this->input->post('rss'));
            $this->podcasts_model->setTags($this->input->post('tags'));
            $this->podcasts_model->setId_createur($this->user->id);

            $this->podcasts_model->insert();
            redirect('podcasts/create/'.$this->podcasts_model->getId());
        }

        $attributes = [
            [        
                'type' => 'text',
                'name' => 'titre',
                'id' => 'titre',
                'label' => 'Nom du podcast',
                'class' => 'form-control',
            ],
            [        
                'type' => 'text',
                'name' => 'description',
                'id' => 'description',
                'label' => 'Description',
                'class' => 'form-control',
            ],
            [        
                'type' => 'text',
                'name' => 'lien',
                'id' => 'lien',
                'label' => 'Site internet',
                'class' => 'form-control',
            ],
            [        
                'type' => 'text',
                'name' => 'image',
                'id' => 'image',
                'label' => 'Logo',
                'class' => 'form-control',
            ],
            [        
                'type' => 'text',
                'name' => 'rss',
                'id' => 'rss',
                'label' => 'Flux rss',
                'class' => 'form-control',
            ],
            [        
                'type' => 'text',
                'name' => 'tags',
                'id' => 'tags',
                'label' => 'Nuage de tags',
                'class' => 'form-control',
            ],
        ];

        $this->template->load('podcasts/create', ['attributes' => $attributes]);
    }

    /**
     * 
     */
    public function createWaitingValidation($id)
    {
        $this->load->model('podcasts_model');
        $podcast = $this->podcasts_model->findOneById($id);

        $this->template->load('podcasts/waiting_validation', ['podcast' => $podcast]);
    }

    /**
     * 
     */
    public function index()
    {
        $this->load->library('rss_import');
        $this->load->model('podcasts_model');
        $podcasts = $this->podcasts_model->findByUser($this->user->id);

        $this->template->load('podcasts/list', ['podcasts' => $podcasts]);
    }

    /**
     * 
     */
    public function edit($id)
    {
        $this->load->model('podcasts_model');
        $this->load->model('episodes_model');
        $podcast = $this->podcasts_model->findOneById($id);
        $episodes = $this->episodes_model->findByPodcast($podcast->id);

        $this->template->load('podcasts/edit', [
            'podcast' => $podcast,
            'episodes' => $episodes
            ]);
    }

    /**
     * XHR
     */
    public function sync($id)
    {
        $this->load->model('podcasts_model');

        $podcast = $this->podcasts_model->findOneById($id);

        $this->load->library('rss_import');
        $this->rss_import->sync($podcast);
    }
}