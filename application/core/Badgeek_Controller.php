<?php

class Badgeek_Controller extends CI_Controller 
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['badgeek']);
        $this->load->library(['session', 'helper']);
        $this->load->database();
        $this->load->model('podcasts_model');
        $this->user = false;

        if($this->ion_auth->logged_in())
        {
            //Utilisateur connecté 
            $user = $this->ion_auth->user()->row();
            if(empty($this->session->user) || key_exists("force_init", $_GET)  || !empty($this->session->reload))
            {
                $user->avatar = getAvatar($user->id);
                $user->groups = $this->ion_auth->get_users_groups($user->id)->result();
                $user->groups_id = $user->groups;
                array_walk($user->groups_id, function(&$element){ $element = $element->id;});
                $this->session->user = $user;
                $this->session->unset_userdata("reload");
            }
            if($user->active == Users_Model::ACTIVE) 
            {
                //Utilisateur actif
                $this->user = $this->session->user;
                //Récupération des préférences
                $this->user->prefs_decoded = $this->helper->get_user_prefs();
                //Liste de ses podcasts
                $this->user_podcasts = $this->podcasts_model->findByUserNotRefused($this->user->id);
                //Gestion des groupes auxquel il appartient
                if(empty($this->session->groups) || key_exists("force_init", $_GET ))
                {
                    $this->session->groups = $this->db->select()->where("id > 1")->get($this->ion_auth_model->tables['groups'])->result_array();
                }
                $this->groups = $this->session->groups;
            }
            else
            {
                //Utilisateur désactivé - On détruit sa session et on le prévient.
		        $this->ion_auth->logout();
		        //Renvoi à la page d'accueil avec un message
                setFlashdataMessage($this->session, 
                    $user->active == Users_Model::DESACTIVE ? $this->getErrorMessage("utilisateur_desactive") : $this->getErrorMessage("utilisateur_non_active"),
                      "top-center");
                redirect('/', 'refresh');
            }
        }
    }

    public function checkAdminRights()
    {
        if (!$this->ion_auth->is_admin(($this->session->userdata('user_id')))) {
            setFlashdataMessage($this->session,'Vous n\'avez pas les droits d\'accès','top-right');
            redirect('/', 'refresh');
        }
    }

    
    public function real_url($url)
    {
        return filter_var($url, FILTER_VALIDATE_URL) || empty($url) ? true : false;

    }

    public function getErrorMessage($cle)
    {
        $this->lang->load("badgeek_errors");
        return $this->lang->line($cle);
    }
}