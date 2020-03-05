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


    public function getIndexData(){
        $result = $this->Articles_model->getAllArticles();
        $this->template->get_adminContents('public/Admin/admin', array("result" => $result));
    }

    public function addArticle()
    {

        $this->load->helper("form");
        $this->form_validation->set_rules('title', 'Titre', 'required|htmlspecialchars');
        $this->form_validation->set_rules('content', 'Contenu', 'required|htmlspecialchars');
        if ($this->form_validation->run()) {
            $idauthor = $this->session->userdata('user_id'); // id auteur = id utilisateur courrant
            $status = null !== $this->input->post('status') ? 1 : 0;   //etat de l'article (visible / non visible). Par défaut 1 pour visible
            if($_FILES['picture']['size']!==0) { // presence de fichier
                $uploadReport = $this->uploadFile();
                if ($uploadReport['status']) { // upload ok, pas d'erreur
                    $this->Articles_model->addArticleByIDWithPicture($this->input->post('title'), $this->input->post('content'), $status, $uploadReport['filename']);
                    setFlashdataMessage($this->session, 'article mis à jour', '', 'top-right');
                    redirect('/admin', 'refresh');
                }else { // erreur lors de l'upload
                    $this->template->load_admin('public/Admin/admin_articles_newArticle',array("error"=>$uploadReport['error']));
                }
            }else { // pas de presence de fichier
                $this->Articles_model->addArticleWithoutPicture($this->input->post('title'), $this->input->post('content'), $idauthor, $status);
                setFlashdataMessage($this->session, 'article ajouté en base de données', '', 'top-right');
                redirect('/admin');
            }
        } else {
//pas de validation ou validation incorecte ,afficher les message d'erreur en cas d'erreur
            $this->template->load_admin('public/Admin/admin_articles_newArticle',array('error'=>''));
        }
    }

    public function editArticle($id)
    {
        $this->load->helper("form");
        $this->form_validation->set_rules('title', 'Titre', 'required|htmlspecialchars');
        $this->form_validation->set_rules('content', 'Contenu', 'required|htmlspecialchars');

        $article = $this->Articles_model->getArticleByID($id);
        if ($this->form_validation->run()) {
           $status = (null !== $this->input->post('status')) ? 1 : 0; //etat de l'article (visible / non visible). Par défaut 1 pour visible
            if($_FILES['picture']['size']!==0) { // presence de fichier
                $uploadReport = $this->uploadFile();
                if ($uploadReport['status']) { // upload ok, pas d'erreur
                    $this->Articles_model->updateArticleByIDWithPicture($id, $this->input->post('title'), $this->input->post('content'), $status,$uploadReport['filename']);
                    setFlashdataMessage($this->session, 'article mis à jour', '', 'top-right');
                    redirect('/admin', 'refresh');
                }else{ // erreur lors de l'upload
                    $this->template->load_admin('public/Admin/admin_articles_editArticle', array("article" => $article,"error"=>$uploadReport['error']));
                }
            }else {
                $this->Articles_model->updateArticleByIDWithoutPicture($id, $this->input->post('title'), $this->input->post('content'), $status);
                setFlashdataMessage($this->session, 'article mis à jour', '', 'top-right');
                redirect('/admin', 'refresh');
            }
        } else {
//pas de validation ou validation incorecte ,afficher les message d'erreur en cas d'erreur
            $this->template->load_admin('public/Admin/admin_articles_editArticle', array("article" => $article,"error"=>''));
        }
    }

    public function removeArticle($id)
    {
        $this->Articles_model->deleteArticleByID($id);
        $response['success']=1;
        header('Content-Type: application/json');
        echo json_encode($response);
    }

    private function uploadFile(){
        $config['upload_path']          = './assets/pictures/news';
        $config['allowed_types']        = 'jpg|png';
        $config['max_size']             = 100;
        $config['max_width']            = 1024;
        $config['max_height']           = 768;
        $config['file_name']            ='news_picture';

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('picture'))
        {
            $error = array('error' => $this->upload->display_errors());
            return array('status'=>FALSE, 'error' =>$error['error']);
        }
        else
        {
            $data = array('upload_data' => $this->upload->data());
            return array('status'=>TRUE, 'error' =>'','filename' =>  $data['upload_data']['file_name']);

        }
    }
}