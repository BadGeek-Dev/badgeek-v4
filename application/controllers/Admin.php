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
        $this->load->library('form_validation');
    }


    public function index()
    {
        $result = $this->Articles_model->getAllArticles();
        //Gestion fil d'Ariane
        $this->template->load_admin('public/admin', array(
            "result" => $result, 
            "liste_BreadcrumbItems" => $this->initBreadcrumbItem(true)
        ));
    }

    public function addArticle()
    {
        $this->load->helper("form");
        $this->form_validation->set_rules('title','Titre','required|htmlspecialchars');
        $this->form_validation->set_rules('content','Contenu','required|htmlspecialchars');

        if ($this->form_validation->run()) {
            $idauthor = $this->session->userdata('user_id'); // id auteur = id utilisateur courrant
            $status = null !== $this->input->post('status') ? 1 :0;   //etat de l'article (visible / non visible). PAr défaut 1 pour visible
            $this->load->model('Articles_model');
            $this->Articles_model->addArticle($this->input->post('title'),$this->input->post('content'),$idauthor,$status);
            setFlashdataMessage($this->session,'article ajouté en base de données','','top-right');
            redirect('/admin');
        } else {
            //pas de validation ou validation incorecte ,afficher les message d'erreur en cas d'erreur
            $this->template->load_admin('public/admin_newArticle', array(
                "liste_BreadcrumbItems" => $this->getBreadcrumbItems(new BreadcrumbItem("Ecrire un nouvel article"))
            ));
        }
    }

    public function editArticle($id)
    {
        $this->load->helper("form");
        $this->form_validation->set_rules('title','Titre','required|htmlspecialchars');
        $this->form_validation->set_rules('content','Contenu','required|htmlspecialchars');
        $article=$this->Articles_model->getArticleByID($id);

        if ($this->form_validation->run()) {
            // validation ok, editer l'article en BDD
            if (null !== $this->input->post('status')) {
                $status = 1; //etat de l'article (visible / non visible). Par défaut 1 pour visible
            } else {
                $status = 0;
            }
            $this->Articles_model->updateArticleByID($id, $this->input->post('title'), $this->input->post('content'), $status);
            setFlashdataMessage($this->session,'article mis à jour','','top-right');
            redirect('/admin','refresh');
        } else {
            //pas de validation ou validation incorecte ,afficher les message d'erreur en cas d'erreur
            $this->template->load_admin('public/admin_editArticle', array(
                "article" => $article,
                "liste_BreadcrumbItems" => $this->getBreadcrumbItems(new BreadcrumbItem("Editer l'article '".$article->title."'"))
            ));
        }
    }

    public function removeArticle($id)
    {
        $this->Articles_model->deleteArticleByID($id);
        setFlashdataMessage($this->session,'article supprimé','','top-right');
        redirect('/admin','refresh');
    }

    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueilAdmin($current));
    }

    private function getBreadcrumbItems($extra_liste_items)
    {
        if(!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
        return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
    }

}
