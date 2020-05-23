<?php

class Badgeek_Controller extends CI_Controller 
{
    public $data = [];

    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['badgeek']);
        $this->load->library('session');
        $this->load->database();
        $this->user = false;

        if($this->ion_auth->logged_in())
        {
            if(empty($this->session->user) || key_exists("force_init", $_GET)  || !empty($this->session->reload))
            {
                $user = $this->ion_auth->user()->row();
                $user->avatar = getAvatar($user->id);
                $user->groups = $this->ion_auth->get_users_groups($user->id)->result();
                $user->groups_id = $user->groups;
                array_walk($user->groups_id, function(&$element){ $element = $element->id;});
                $this->session->user = $user;
                $this->session->unset_userdata("reload");
            }
            $this->user = $this->session->user;
        }

        if(empty($this->session->groups) || key_exists("force_init", $_GET ))
        {
            $this->session->groups = $this->db->select()->where("id > 1")->get($this->ion_auth_model->tables['groups'])->result_array();
        }
        $this->groups = $this->session->groups;
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
        return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED) || empty($url) ? true : false;

    }
}