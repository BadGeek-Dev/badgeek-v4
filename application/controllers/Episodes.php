<?php

require_once APPPATH . 'core/Badgeek_Controller.php';

class Episodes extends Badgeek_Controller
{
    public $private_dir = "";

    public function __construct()
    {
        parent::__construct();

        $this->load->model('podcasts_model');
        $this->load->model('episodes_model');
        $this->load->library('helper');

        $this->private_dir = getPrivateDir($this->user->id);
    }

    /**
     * 
     */
    public function create($id)
    {
        $podcast = $this->podcasts_model->findOneById($id);
        if (empty($podcast->hosted)) {
            $this->goBackError();
        }
        if (!$this->ion_auth->logged_in()) {
            $this->goBackError();
        }
       

        $this->load->helper('form');
        $this->load->library('form_validation');

        $this->form_validation->set_rules('titre', 'Nom du podcast', 'required');
        $this->form_validation->set_rules('description', 'Description', 'required');
        $this->form_validation->set_rules('saison', 'Saison', 'required');
        $this->form_validation->set_rules('numero', 'Numero', 'required');
        $this->form_validation->set_rules('lien_mp3', 'MP3', 'required');
        $errors = "";
        if (false === $this->form_validation->run()) {
        } else {

            $this->episodes_model->setNumero($this->helper->numero($this->input->post('saison'), $this->input->post('numero')));
            $this->episodes_model->setTitre($this->input->post('titre'));
            $this->episodes_model->setDescription($this->input->post('description'));

            //Gestion MP3
            $this->load->library('mp3_info');
            $upload_mp3_filepath = $this->private_dir . "/" . $this->input->post('lien_mp3');
            if (is_file($upload_mp3_filepath)) {
                //Création du dossier private/id_user/podcast
                $podcast_dir = $this->private_dir . "/" . $podcast->id;
                if (!is_dir($podcast_dir)) {
                    mkdir($podcast_dir);
                }
                //Création du dossier private/id_user/podcast/episode
                $episode_dir = $podcast_dir . "/" . $this->episodes_model->getNumero();
                if (!is_dir($episode_dir)) {
                    mkdir($episode_dir);
                }
                $episode_mp3_filepath = $episode_dir . "/" . $this->input->post('lien_mp3');
                rename($upload_mp3_filepath, $episode_mp3_filepath);

                $mp3Info = $this->mp3_info->analyze($episode_mp3_filepath);
                $mp3Size = filesize($episode_mp3_filepath);

                $this->episodes_model->setInfos_mp3('Durée : ' . $mp3Info['playtime_string'] . ' Taille : ' . $mp3Size);
                $this->episodes_model->setTags($this->input->post('tags'));
                $this->episodes_model->setLien_mp3(getBaseUrlFromRealpath($episode_mp3_filepath));
                $this->episodes_model->setValid(Podcasts_model::EN_ATTENTE);
                $this->episodes_model->setDate_publication((new \DateTime())->format("Y-m-d H:i:s"));
                $this->episodes_model->setId_podcast($podcast->id);

                $this->episodes_model->insert();
                redirect('episodes/validate/' . $this->episodes_model->getId());
            } else {
                $errors = "Impossible de trouver le MP3";
            }
        }
        $lastEpisode = $this->episodes_model->findLastByPodcast($podcast);

        $lastNumber = null;
        $lastSeason = null;
        if ($lastEpisode) {
            list($lastSeason, $lastNumber) = $this->helper->numero_inverse($lastEpisode->numero);
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
                'value' => $this->input->post('numero') ?: $lastNumber + 1,
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
            'list_files' => getPrivateListOfFileForUser($this->user->id),
            "liste_BreadcrumbItems" => $this->getBreadcrumbItems([
                new BreadcrumbItem($podcast->titre, "/podcasts/display/" . $podcast->id),
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
                new BreadcrumbItem($podcast->titre, "/podcasts/display/" . $podcast->id),
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

        if ($podcast->id_createur != $this->user->id) {
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
            redirect('episodes/view/' . $episode->id);
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
                new BreadcrumbItem($podcast->titre, "/podcasts/display/" . $podcast->id),
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

            redirect('/podcasts/display/' . $podcast->id);
        }

        $this->template->load('episodes/validate', [
            'episode' => $episode,
            'podcast' => $podcast,
            "liste_BreadcrumbItems" => $this->getBreadcrumbItems([
                new BreadcrumbItem($podcast->titre, "/podcasts/display/" . $podcast->id),
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

        redirect('/podcasts/display/' . $podcast->id);
    }

    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueil(), new BreadcrumbItem("Podcasts", "/podcasts", $current));
    }

    private function getBreadcrumbItems($extra_liste_items)
    {
        if (!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
        return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
    }
}
