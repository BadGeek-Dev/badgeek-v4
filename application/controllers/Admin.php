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
        $query = $this->db->query('SELECT badgeek.articles.id,badgeek.articles.title,badgeek.articles.content,badgeek.articles.created_at, badgeek.users.username FROM badgeek.articles INNER JOIN badgeek.users ON badgeek.articles.id_author = badgeek.users.id WHERE badgeek.articles.id > 0');
        foreach ($query->result() as $row) {
            $data[] = (array)$row;
        }

        $this->template->load('public/admin', array("result" => $data));
    }

    public function addArticle()
    {
        $this->checkAdminRights();
        $this->load->helper("form");
        $this->load->library('form_validation');
        if ($this->form_validation->run()) {
            // validation ok, ajouter l'article en BDD
//            $this->template->load('public/admin_newArticle');

            $this->load->database();
            $idauthor = $this->session->userdata('user_id'); // id auteur = id utilisateur courrant

            if (null !== $this->input->post('status')) {
                $status = 1; //etat de l'article (visible / non visible). PAr défaut 1 pour visible
            } else {
                $status = 0;
            }
            $sql = "Insert into badgeek.articles(content,id_author,status,title,created_at) values (?,?,?,?,NOW())";
            $this->db->query($sql, array($this->input->post('content'), $idauthor, $status, $this->input->post('title')));

//            $flashMessage["message"] = ;
            $this->session->set_flashdata('message', "article ajouté en base de données");
            $this->session->set_flashdata('message-timeout', 10000);
            //ajouter message flash pour indiquer à l'utilisateur que l'article a été ajouté en bdd
            $this->index();
        } else {
            //pas de validation ou validation incorecte ,afficher les message d'erreur en cas d'erreur
            $this->template->load('public/admin_newArticle');
        }
    }

    public function editArticle($id)
    {
        $this->checkAdminRights();
        $this->load->helper("form");
        $this->load->library('form_validation');
        $this->load->database();
        $sql = "SELECT * from badgeek.articles WHERE id = ?";
        $result = $this->db->query($sql, array($id));
        $article = (array)$result->result()[0];
        $article['id'] = $id;
        if ($this->form_validation->run()) {
            // validation ok, editer l'article en BDD
            if (null !== $this->input->post('status')) {
                $status = 1; //etat de l'article (visible / non visible). Par défaut 1 pour visible
            } else {
                $status = 0;
            }
            //mise a jour de l'article => SQL Update
            $sql = "UPDATE badgeek.articles SET `content` = ?,stauts = ?, title = ?, `created_at` = NOW() WHERE (`id` = ?);";
            $this->db->query($sql, array($this->input->post('content'), $status, $this->input->post('title'), $id));
            $this->index();
            //ajouter message flash pour indiquer à l'utilisateur que l'article a été modifié en bdd
            $this->session->set_flashdata('message', "article mis à jour");
            $this->session->set_flashdata('message-timeout', 10000);
        } else {
            //pas de validation ou validation incorecte ,afficher les message d'erreur en cas d'erreur
            $this->template->load('public/admin_editArticle', array("article" => $article));
        }
    }

    public function removeArticle($id)
    {
        $this->checkAdminRights();
        $this->load->database();
        $sql = "DELETE FROM badgeek.articles WHERE id =?";
        $this->db->query($sql, array($id));
        // ajouter message flash indiquant que la suppression d'article s'est bien passée
        $this->session->set_flashdata('message', "article supprimé");
        $this->session->set_flashdata('message-timeout', 10000);

        $this->index();
    }

    private function checkAdminRights()
    {
        if (!$this->ion_auth->is_admin(($this->session->userdata('user_id')))) {
            $this->session->set_flashdata('message', "Vous n'avez pas les droits d'accès");
            $this->session->set_flashdata('message-timeout', 10000);
            redirect('/', 'refresh');
        }
    }
}
