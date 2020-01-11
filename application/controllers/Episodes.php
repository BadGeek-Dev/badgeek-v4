<?php

require_once APPPATH . 'core/Badgeek_Controller.php'; 

class Episodes extends Badgeek_Controller 
{
    /**
     * 
     */
    public function create($id)
    {
        $this->load->model('podcasts_model');
        $podcast = $this->podcasts_model->findOneById($id);

        if (!$this->ion_auth->logged_in()) {
            redirect('badgeek/index');
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('titre', 'Nom du podcast', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        if (false === $this->form_validation->run()) {
            
        } else {
            $this->load->model('episodes_model');
            $this->episodes_model->setNumero($this->input->post('numero'));
            $this->episodes_model->setTitre($this->input->post('titre'));
            $this->episodes_model->setDescription($this->input->post('description'));
            $this->episodes_model->setLien_mp3($this->input->post('lien_mp3'));
            $this->episodes_model->setInfos_mp3($this->input->post('infos_mp3'));
            $this->episodes_model->setTags($this->input->post('tags'));

            $this->episodes_model->setDate_publication($this->input->post('date_publication'));
            $this->episodes_model->setId_podcast($podcast->id);

            $this->episodes_model->insert();
            redirect('episodes/edit/'.$this->episodes_model->getId());
        }

        $attributes = [
            [        
                'type' => 'text',
                'name' => 'numero',
                'id' => 'numero',
                'label' => 'Numéro',
                'class' => 'form-control',
            ],
            [        
                'type' => 'text',
                'name' => 'titre',
                'id' => 'titre',
                'label' => 'Titre',
                'class' => 'form-control',
            ],
            [        
                'type' => 'date',
                'name' => 'date_publication',
                'id' => 'date_publication',
                'label' => 'Date de publication',
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
                'name' => 'lien_mp3',
                'id' => 'lien_mp3',
                'label' => 'Lien vers le mp3',
                'class' => 'form-control',
            ],
            [        
                'type' => 'text',
                'name' => 'infos_mp3',
                'id' => 'infos_mp3',
                'label' => 'Infos du mp3',
                'class' => 'form-control',
            ],
            [        
                'type' => 'text',
                'name' => 'tags',
                'id' => 'tags',
                'label' => 'Tags',
                'class' => 'form-control',
            ],
        ];

        $this->template->load('episodes/create', [
            'podcast' => $podcast, 'attributes' => $attributes
            ]);
    }

    /**
     * 
     */
    public function edit($id)
    {
        $this->load->model('episodes_model');
        $this->load->model('podcasts_model');

        $episode = $this->episodes_model->findOneById($id);
        $podcast = $this->podcasts_model->findOneById($episode->id_podcast);

        $this->template->load('episodes/edit', [
            'episode' => $episode, 'podcast' => $podcast
            ]);
    }
}