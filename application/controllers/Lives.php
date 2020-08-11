<?php

require_once APPPATH . 'core/Badgeek_Controller.php';

class Lives extends Badgeek_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->load->model('Lives_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $result = $this->Lives_model->getLiveByMember($this->session->userdata('user_id'));
        $this->template->load('public/lives/index', array("result" => $result,
            'liste_BreadcrumbItems' =>  $this->getBreadcrumbItems(new BreadcrumbItem("Mes Lives"))
        ));
    }

    public function requestLive()
    {
        $this->load->helper("form");
        $this->form_validation->set_rules('title','Titre','required|htmlspecialchars');
        $this->form_validation->set_rules('content','Motif','htmlspecialchars');
        $this->form_validation->set_rules('start_at','Date de Début','required|htmlspecialchars');
        $this->form_validation->set_rules('start_at_hour','Heure de Début','required|htmlspecialchars');
        if($this->form_validation->run()){

            $idmember = $this->session->userdata('user_id');
            $this->input->post('start_at');

            $this->Lives_model->addLive(
                $this->input->post('title'),
                $this->input->post('content'),
                $this->input->post('start_at') . " " . $this->input->post('start_at_hour'),
                $idmember);
            setFlashdataMessage($this->session, 'Demande de Live créée');
            redirect("/lives");
        }
        else{
           $this->template->load('public/lives/live_newLive.php',array(
               'error' => validation_errors(),
               "liste_BreadcrumbItems" => $this->getBreadcrumbItems(new BreadcrumbItem("Demande de live"))));
        }
    }


    public function editLive($id)
    {
        $this->load->helper("form");
        $this->form_validation->set_rules('title','Titre','required|htmlspecialchars');
        $this->form_validation->set_rules('content','Motif','htmlspecialchars');
        $this->form_validation->set_rules('start_at','Date de Début','required|htmlspecialchars');
        $liverequest = $this->Lives_model->getLiveById($id);
        if($this->form_validation->run()){

            $idmember = $this->session->userdata('user_id');
            $this->input->post('start_at');

            $this->Lives_model->updateLive($id,
                $this->input->post('title'),
                $this->input->post('content'),
                $this->input->post('start_at'),
                $idmember,$liverequest->created_at);
            setFlashdataMessage($this->session, 'Edition de Live effectuée');
            redirect("/lives");
        }
        else{


            $this->template->load('public/lives/live_editLive.php',array(
                'live' => $liverequest,
                'error' => validation_errors(),
                "liste_BreadcrumbItems" => $this->getBreadcrumbItems(new BreadcrumbItem("Demande de live"))));
        }
    }

    public function live($id){
    $live = $this->Lives_model->getLiveById($id);

    if($live->status == 2 ){
        $this->template->load('public/lives/live.php',array(
            'live' => $live,
            "liste_BreadcrumbItems" => $this->getBreadcrumbItems(new BreadcrumbItem("Demande de live"))));}
    else{
        redirect('/', 'refresh');
    }
}



    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueil(false), new BreadcrumbItem("Lives","/lives", $current));
    }

    private function getBreadcrumbItems($extra_liste_items)
    {
        if(!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
        return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
    }


}