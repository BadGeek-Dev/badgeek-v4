<?php

require_once APPPATH . 'core/Badgeek_Controller.php';

class Admin_articles extends Badgeek_Controller
{
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
        $this->template->load_admin('public/Admin/admin_articles', array(
            "result" => $result,
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true)
        ));
    }
    public function add()
    {
        $this->edit(0);
    }

    public function edit($id)
    {
        $this->load->helper("form");
        $this->form_validation->set_rules('title', 'Titre', 'required|htmlspecialchars');
        $this->form_validation->set_rules('content', 'Contenu', 'required|htmlspecialchars');

        $article = $id ? $this->Articles_model->getArticleByID($id) : false;
        if ($this->form_validation->run()) 
        {
            $status = (null !== $this->input->post('status')); //etat de l'article (visible / non visible). Par défaut 1 pour visible
            $has_picture = ($_FILES["picture"]["size"] != 0);
            if($has_picture) { 
                // presence de fichier
                $uploadReport = $this->uploadFile();
                if (!$uploadReport['status']) 
                {
                    // erreur lors de l'upload
                    $this->template->load_admin('public/Admin/admin_articles_editArticle', 
                        array("article" => $article, 
                            "error_upload"=>$uploadReport['error']));
                    return;
                }
            }
            if($article)
            {   
                //Edition d'un article
                $this->Articles_model->updateArticle(
                    $id, 
                    $this->input->post('title'), 
                    $this->input->post('content'), 
                    $status, 
                    $has_picture ? $uploadReport['filename'] : false);
                    setFlashdataMessage($this->session, 'Article mis à jour');
            }
            else
            {
                //Ajout d'un article
                $this->Articles_model->addArticle(
                    $this->input->post('title'), 
                    $this->input->post('content'), 
                    $this->session->userdata('user_id'), 
                    $status, 
                    $has_picture ? $uploadReport['filename'] : false);
                setFlashdataMessage($this->session, 'Article créé');
            }
            redirect('/admin_articles/index', 'refresh');
        } else {
            //pas de validation ou validation incorrecte ,afficher les message d'erreur en cas d'erreur
            if($article)
            {
                $this->template->load_admin("admin/articles_edit", 
                array(
                    "article" => $article,
                    "error"=> validation_errors(),
                    "liste_BreadcrumbItems" => $this->getBreadcrumbItems(new BreadcrumbItem($article->title))
                    )
                );
            }
            else
            {
                //Garder les valeurs en INPUT 
                $this->template->load_admin("admin/articles_add", 
                array(
                    "post_title" => $this->input->post("title"),
                    "post_content" => $this->input->post("content"),
                    "error"=> validation_errors(),
                    "liste_BreadcrumbItems" => $this->getBreadcrumbItems(new BreadcrumbItem("Nouvel article"))
                    )
                );
            }
        }
    }

    public function delete($id)
    {
        if($this->Articles_model->deleteArticleByID($id))
        {
            setFlashdataMessage($this->session, "Article supprimé");
        }
        else
        {
            setFlashdataMessage($this->session, "Erreur lors de la suppression de l'article.");
        }
        echo json_encode("OK");
    }

    private function uploadFile()
    {
        $config['upload_path']          = './assets/pictures/news';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;
        $config['file_name']            ='news_picture';

        $this->load->library('upload', $config);

        if ($this->upload->do_upload('picture'))
        {
            $data = array('upload_data' => $this->upload->data());
            return array('status'=>TRUE, 'error' =>'','filename' =>  $data['upload_data']['file_name']);
        }
        else
        {
            $error = array('error' => $this->upload->display_errors());
            return array('status'=>FALSE, 'error' =>$error['error']);
        }
    }

    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueilAdmin(false), new BreadcrumbItem("Gestion des articles","/admin/articles", $current));
    }

    private function getBreadcrumbItems($extra_liste_items)
    {
        if(!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
        return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
    }


}