<?php

require_once APPPATH . 'core/Badgeek_Controller.php'; 

class Episodes extends Badgeek_Controller 
{
    public function __construct()
    {
        parent::__construct();

        $this->load->model('podcasts_model');
        $this->load->model('episodes_model');
        $this->load->library('helper');
    }

    /**
     * 
     */
    public function create($id)
    {
        $podcast = $this->podcasts_model->findOneById($id);
        $lastEpisode = $this->episodes_model->findLastByPodcast($podcast);

        $lastNumber = null;
        $lastSeason = null;
        if ($lastEpisode) {
            list($lastSeason, $lastNumber) = $this->helper->numero_inverse($lastEpisode->numero);
        }

        if (!$this->ion_auth->logged_in()) {
            redirect('badgeek/index');
        }

        $config['upload_path'] = './uploads/podcasts/'.$podcast->id.'/';
        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0777, TRUE);
        }
        $config['allowed_types'] = 'mp3';

        $this->load->library('upload', $config);
        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('titre', 'Nom du podcast', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        $errors = '';

        if (false === $this->form_validation->run()) {
            
        } else {
            if (!$this->upload->do_upload('lien_mp3')) {
                $errors = $this->upload->display_errors();
            } else {

                $this->load->library('mp3_info');
                $mp3Info = $this->mp3_info->analyze($this->upload->data()['full_path']);
                $mp3Size = filesize($this->upload->data()['full_path']);

                $this->episodes_model->setLien_mp3($this->upload->data()['full_path']);
                $this->episodes_model->setNumero($this->helper->numero($this->input->post('saison'), $this->input->post('numero')));
                $this->episodes_model->setTitre($this->input->post('titre'));
                $this->episodes_model->setDescription($this->input->post('description'));
                $this->episodes_model->setInfos_mp3('time : ' . $mp3Info['playtime_string'] . ' size : ' . $mp3Size);
                $this->episodes_model->setTags($this->input->post('tags'));
                $this->episodes_model->setValid(Podcasts_model::EN_ATTENTE);

                $this->episodes_model->setDate_publication((new \DateTime())->format("Y-m-d H:i:s"));
                $this->episodes_model->setId_podcast($podcast->id);
    
                $this->episodes_model->insert();
                redirect('episodes/validate/'.$this->episodes_model->getId());
            }
        }

        $attributes = [
            [        
                'type' => 'text',
                'name' => 'saison',
                'id' => 'saison',
                'label' => 'Numéro de la saison',
                'class' => 'form-control',
                'value' => $this->input->post('saison') ?: $lastSeason,
            ],
            [        
                'type' => 'text',
                'name' => 'numero',
                'id' => 'numero',
                'label' => 'Numéro de l\'épisode',
                'class' => 'form-control',
                'value' => $this->input->post('numero') ?: $lastNumber+1,
            ],
            [        
                'type' => 'text',
                'name' => 'titre',
                'id' => 'titre',
                'label' => 'Titre *',
                'class' => 'form-control',
                'value' => $this->input->post('titre'),
                'required' => true,
            ],
            [        
                'type' => 'text',
                'name' => 'description',
                'id' => 'description',
                'label' => 'Description *',
                'class' => 'form-control',
                'value' => $this->input->post('description'),
                'required' => true,
            ],
            [        
                'type' => 'file',
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
                'value' => $this->input->post('infos_mp3'),
            ],
            [        
                'type' => 'text',
                'name' => 'tags',
                'id' => 'tags',
                'label' => 'Tags',
                'class' => 'form-control',
                'value' => $this->input->post('tags')
            ],
        ];

        $this->template->load('episodes/create', [
            'podcast' => $podcast, 
            'attributes' => $attributes,
            'errors' => $errors,
            "liste_BreadcrumbItems" => $this->getBreadcrumbItems([
                new BreadcrumbItem($podcast->titre,"/podcasts/display/".$podcast->id),
                new BreadcrumbItem("Nouvel épisode")
            ])
        ]);
    }

    public function view($id)
    {
        $episode = $this->episodes_model->findOneById($id);
        $podcast = $this->podcasts_model->findOneById($episode->id_podcast);

        $stats = json_decode($episode->stats, true);
        $episode->stats = json_encode([
            'view' => ($stats['view'] ?? 0) + 1,
            'listen' => ($stats['listen'] ?? 0) + 0
        ]);
        $this->episodes_model->update($episode);

        $this->template->load('episodes/view', [
            'episode' => $episode, 
            'podcast' => $podcast,
            "liste_BreadcrumbItems" => $this->getBreadcrumbItems([
                new BreadcrumbItem($podcast->titre,"/podcasts/display/".$podcast->id),
                new BreadcrumbItem($episode->titre)
            ])
        ]); 
    }

    public function statsListen($id)
    {
        $episode = $this->episodes_model->findOneById($id);

        $stats = json_decode($episode->stats, true);
        $episode->stats = json_encode([
            'view' => ($stats['view'] ?? 0) + 0,
            'listen' => ($stats['listen'] ?? 0) + 1
        ]);
        $this->episodes_model->update($episode);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(['sucess' => true]));
    }

    /**
     * 
     */
    public function edit($id)
    {
        $episode = $this->episodes_model->findOneById($id);
        $podcast = $this->podcasts_model->findOneById($episode->id_podcast);

        if ($podcast->id_createur != $this->user->id){
            redirect('/');
        }

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('titre', 'Nom du podcast', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');

        $errors = '';

        if (false === $this->form_validation->run()) {
            
        } else {
            $episode->numero = $this->helper->numero($this->input->post('saison'), $this->input->post('numero'));
            $episode->titre = $this->input->post('titre');
            $episode->description = $this->input->post('description');
            $episode->tags = $this->input->post('tags');

            $this->episodes_model->update($episode);
            redirect('episodes/view/'.$episode->id);
        }

        $attributes = [
            [        
                'type' => 'text',
                'name' => 'saison',
                'id' => 'saison',
                'label' => 'Numéro de la saison',
                'class' => 'form-control',
                'value' => $this->input->post('saison') ?: $this->helper->numero_inverse($episode->numero)[0],
            ],
            [        
                'type' => 'text',
                'name' => 'numero',
                'id' => 'numero',
                'label' => 'Numéro de l\'épisode',
                'class' => 'form-control',
                'value' => $this->input->post('numero') ?: $this->helper->numero_inverse($episode->numero)[1],
            ],
            [        
                'type' => 'text',
                'name' => 'titre',
                'id' => 'titre',
                'label' => 'Titre *',
                'class' => 'form-control',
                'value' => $this->input->post('titre') ?: $episode->titre,
                'required' => true,
            ],
            [        
                'type' => 'text',
                'name' => 'description',
                'id' => 'description',
                'label' => 'Description *',
                'class' => 'form-control',
                'value' => $this->input->post('description') ?: $episode->description,
                'required' => true,
            ],
            [        
                'type' => 'text',
                'name' => 'tags',
                'id' => 'tags',
                'label' => 'Tags',
                'class' => 'form-control',
                'value' => $this->input->post('tags') ?: $episode->tags
            ],
        ];

        $this->template->load('episodes/edit', [
            'episode' => $episode, 
            'podcast' => $podcast,
            'attributes' => $attributes,
            'errors' => $errors,
            "liste_BreadcrumbItems" => $this->getBreadcrumbItems([
                new BreadcrumbItem($podcast->titre,"/podcasts/display/".$podcast->id),
                new BreadcrumbItem($episode->titre)
            ])
        ]);
    }

    public function validate($id)
    {
        $episode = $this->episodes_model->findOneById($id);
        $podcast = $this->podcasts_model->findOneById($episode->id_podcast);

        if ($this->input->get('valid')) {
            $episode->valid = Episodes_model::VALIDE;
            $this->episodes_model->update($episode);

            redirect('/podcasts/display/'.$podcast->id);
        }

        $this->template->load('episodes/validate', [
            'episode' => $episode, 
            'podcast' => $podcast,
            "liste_BreadcrumbItems" => $this->getBreadcrumbItems([
                new BreadcrumbItem($podcast->titre,"/podcasts/display/".$podcast->id),
                new BreadcrumbItem($episode->titre)
            ])
        ]);
    }

    /**
     * 
     */
    public function delete($id)
    {
        $episode = $this->episodes_model->findOneById($id);
        $podcast = $this->podcasts_model->findOneById($episode->id_podcast);

        if ($this->user->id == $podcast->id_createur) {
            $this->episodes_model->delete($episode);
        }

        redirect('/podcasts/display/'.$podcast->id);
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