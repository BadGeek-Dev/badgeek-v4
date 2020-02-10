<?php

require_once APPPATH . 'core/Badgeek_Controller.php';

class Admin extends Badgeek_Controller
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->checkAdminRights();
        $this->load->model('Articles_model');
    }

    public function index()
    {
        $result = $this->Articles_model->getAllArticles();
        $this->template->load_admin('public/admin', array("result" => $result));
    }

    public function addArticle()
    {
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
            
            redirect('/admin');
        } else {
            //pas de validation ou validation incorecte ,afficher les message d'erreur en cas d'erreur
            $this->template->load_admin('public/admin_newArticle');
        }
    }

    public function editArticle($id)
    {
        $this->load->helper("form");
        $this->load->library('form_validation');
        $article = $this->Articles_model->getArticleByID($id);

        if ($this->form_validation->run()) {
            // validation ok, editer l'article en BDD
            if (null !== $this->input->post('status')) {
                $status = 1; //etat de l'article (visible / non visible). Par défaut 1 pour visible
            } else {
                $status = 0;
            }
            $this->Articles_model->updateArticleByID($id, $this->input->post('title'), $this->input->post('content'), $status);
            setFlashdataMessage($this->session,'article mis à jour','','top-right');

            redirect('/admin');
        } else {
            //pas de validation ou validation incorecte ,afficher les message d'erreur en cas d'erreur
            $this->template->load_admin('public/admin_editArticle', array("article" => $article));
        }
    }

    public function removeArticle($id)
    {
        $this->Articles_model->deleteArticleByID($id);
        setFlashdataMessage($this->session,'article supprimé','','top-right');
        
        redirect('/admin');
    }
}
