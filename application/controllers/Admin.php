<?php

require_once APPPATH . 'core/Badgeek_Controller.php';

class Admin extends Badgeek_Controller
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
    }

    public function index()
    {
        $this->checkAdminRights();

        // récupération des données des articles
        $this->load->database();
        $this->load->model('Articles_model');
        $result = (array)$this->Articles_model->getAllArticles();
        foreach ($result as $row) {
            $data[] = (array)$row;
        }
    $this->template->load_admin('public/admin', array("result" => $data));
    }

    public function addArticle()
    {
        $this->checkAdminRights();
        $this->load->helper("form");
        $this->load->library('form_validation');
        if ($this->form_validation->run()) {
            // validation ok, ajouter l'article en BDD
            $idauthor = $this->session->userdata('user_id'); // id auteur = id utilisateur courrant
            if (null !== $this->input->post('status')) {
                $status = 1; //etat de l'article (visible / non visible). PAr défaut 1 pour visible
            } else {
                $status = 0;
            }
            $this->load->database();
            $this->load->model('Articles_model');
            $this->Articles_model->addArticle($this->input->post('title'),$this->input->post('content'),$idauthor,$status);
            setFlashdataMessage($this->session,'article ajouté en base de données','','top-right');
            $this->index();
        } else {
            //pas de validation ou validation incorecte ,afficher les message d'erreur en cas d'erreur
            $this->template->load_admin('public/admin_newArticle');
        }
    }

    public function editArticle($id)
    {
        $this->checkAdminRights();
        $this->load->helper("form");
        $this->load->library('form_validation');
        $this->load->database();
        $this->load->model('Articles_model');
        $article=(array)$this->Articles_model->getArticleByID($id);

        if ($this->form_validation->run()) {
            // validation ok, editer l'article en BDD
            if (null !== $this->input->post('status')) {
                $status = 1; //etat de l'article (visible / non visible). Par défaut 1 pour visible
            } else {
                $status = 0;
            }
            $this->Articles_model->updateArticleByID($id, $this->input->post('title'), $this->input->post('content'), $status);
            setFlashdataMessage($this->session,'article mis à jour','','top-right');
            $this->index();
        } else {
            //pas de validation ou validation incorecte ,afficher les message d'erreur en cas d'erreur
            $this->template->load_admin('public/admin_editArticle', array("article" => $article));
        }
    }

    public function removeArticle($id)
    {
        $this->checkAdminRights();
        $this->load->database();
        $this->load->model('Articles_model');
        $this->Articles_model->deleteArticleByID($id);
        setFlashdataMessage($this->session,'article supprimé','','top-right');
        $this->index();
    }

    private function checkAdminRights()
    {
        if (!$this->ion_auth->is_admin(($this->session->userdata('user_id')))) {
            setFlashdataMessage($this->session,'Vous n\'avez pas les droits d\'accès','','top-right');
            redirect('/', 'refresh');
        }
    }
}
