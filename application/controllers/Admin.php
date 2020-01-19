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
            $this->template->load('public/admin_newArticle');

            $this->load->database();
            $idauthor = $this->session->userdata('user_id'); // id auteur = id utilisateur courrant
            $status = 1; //etat de l'article (visible / non visible). PAr défaut 1 pour visible
            $sql = "Insert into badgeek.articles(content,id_author,status,title,created_at) values (?,?,?,?,NOW())";
            $this->db->query($sql, array($this->input->post('content'), $idauthor, $status, $this->input->post('title')));

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
            echo "good";
            // validation ok, editer l'article en BDD
            $status = 1; //etat de l'article (visible / non visible). PAr défaut 1 pour visible
            //mise a jour de l'article => SQL Update
            $sql = "UPDATE badgeek.articles SET `content` = ?, title = ?, `created_at` = NOW() WHERE (`id` = ?);";
            $this->db->query($sql, array($this->input->post('content'), $this->input->post('title'), $id));
            $this->index();
            //ajouter message flash pour indiquer à l'utilisateur que l'article a été ajouté en bdd
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
        $this->index();
    }

    private function checkAdminRights()
    {
        if (!$this->ion_auth->is_admin(($this->session->userdata('user_id')))) {
            redirect('/', 'refresh');
        }
    }
}
