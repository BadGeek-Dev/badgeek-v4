<?php

require_once APPPATH . 'core/Badgeek_Controller.php';

class Admin_lives extends Badgeek_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->library('ion_auth');
        $this->load->library(['email']);
        $this->checkAdminRights();
        $this->load->model('Lives_model');
        $email_config = $this->config->item('email_config', 'ion_auth');

        if ($this->config->item('use_ci_email', 'ion_auth') && isset($email_config) && is_array($email_config))
        {
            $this->email->initialize($email_config);
        }

    }

    public function index()
    {
        $result = $this->Lives_model->getLives();
        $this->template->load_admin('public/Admin/admin_lives', array(
            "result" => $result,
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true)
        ));
    }

    public function view($id)
    {
        $result = $this->Lives_model->getLiveById($id);
        $this->template->load_admin('public/Admin/admin_lives_viewRequest', array(
            "result" => $result,
            'liste_BreadcrumbItems' => $this->getBreadcrumbItems(new BreadcrumbItem($result->id))
        ));

    }


    public function refuse($id)
    {
        $this->Lives_model->updateStatus($id, 0);

        $username = $this->Lives_model->getUsernameByLiveId($id);
        setFlashdataMessage($this->session, "La demande du live de " . $username . " a été refusée");

        $live = $this->Lives_model->getLiveByID($id);



        $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
        $this->email->to($username);


        $this->email->subject('Refus de demande pour le live '.$live->title);
        $this->email->set_alt_message('Testing the email class.');
        $this->email->message('<h1>Refus de demande pour le live '.$live->title.'</h1><p>Désolé , mais votre demande de live '.$live->title.' a été refusée.</p> <p>L\'équipe de Modération Badgeek</p>');
        $this->email->send();



        $this->index();
    }

    public function accept($id)
    {

        $this->Lives_model->updateStatus($id, 2);
        $this->Lives_model->updateUrl($id, site_url("lives/live/".$id));
        $username = $this->Lives_model->getUsernameByLiveId($id);
        setFlashdataMessage($this->session, "La demande du live de " . $username . " a été acceptée");

        $live = $this->Lives_model->getLiveByID($id);

        
        $this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
        $this->email->to($username);


        $this->email->subject('Approbation de votre demande pour le live '.$live->title);
        $this->email->set_alt_message('Testing the email class.');
        $this->email->message('<h1>Approbation de votre demande pour le live '.$live->title.'</h1><p>Bonjour,votre demande de live '.$live->title.' a été acceptée.<br/> Votre page de live est : <a href="'.site_url("lives/live/".$id).'">'.site_url("lives/live/".$id).'</a></p> <p>L\'équipe de Modération Badgeek</p>');
        $this->email->send();
        $this->index();
    }

    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueilAdmin(false), new BreadcrumbItem("Lives", "/admin/lives", $current));
    }

    private function getBreadcrumbItems($extra_liste_items)
    {
        if (!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
        return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
    }


}