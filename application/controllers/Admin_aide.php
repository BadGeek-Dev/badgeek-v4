<?php

require_once APPPATH . 'core/Badgeek_Controller.php';

class Admin_aide extends Badgeek_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('ion_auth');
        $this->checkAdminRights();
        $this->load->model('Aides_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $result = $this->Aides_model->getAllAides();
        $this->template->load_admin('public/Admin/admin_aide', array(
            "result" => $result,
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true)
        ));
    }
    public function add()
    {
        $this->load->helper("form");
        $this->form_validation->set_rules('title', 'Titre', 'required|htmlspecialchars');
        $this->form_validation->set_rules('content', 'Contenu', 'required|htmlspecialchars');

        if ($this->form_validation->run()) {
            $idauthor = $this->session->userdata('user_id'); // id auteur = id utilisateur courrant
            $status = null !== $this->input->post('status') ? 1 : 0;   //etat de l'article (visible / non visible). Par défaut 1 pour visible
            $this->Aides_model->addAide(
                $this->input->post('title'),
                $this->input->post('content'),
                $idauthor,
                $status
                );
            setFlashdataMessage($this->session, 'Aide créé');
            redirect('/admin_aide/index');
        } else {
            //pas de validation ou validation incorecte ,afficher les message d'erreur en cas d'erreur
            $this->template->load_admin('public/Admin/admin_aide_addAide',array(
                'error'=> validation_errors(),
                "liste_BreadcrumbItems" => $this->getBreadcrumbItems(new BreadcrumbItem("Nouvelle aide"))));
        }
    }

    public function edit($id)
    {
        $this->load->helper("form");
        $this->form_validation->set_rules('title', 'Titre', 'required|htmlspecialchars');
        $this->form_validation->set_rules('content', 'Contenu', 'required|htmlspecialchars');

        $aide = $this->Aides_model->getAideByID($id);
        if ($this->form_validation->run()) {
            $status = (null !== $this->input->post('status')); //etat de l'article (visible / non visible). Par défaut 1 pour visible
            $this->Aides_model->updateAide(
                $id,
                $this->input->post('title'),
                $this->input->post('content'),
                $status);
            setFlashdataMessage($this->session, 'Aide mise à jour');
			redirect('/admin_aide/index');
        } else {
            //pas de validation ou validation incorecte ,afficher les message d'erreur en cas d'erreur
            $this->template->load_admin('public/Admin/admin_aide_editAide', array(
                "aide" => $aide,
                "error"=> validation_errors(),
                "liste_BreadcrumbItems" => $this->getBreadcrumbItems(new BreadcrumbItem($aide->title))));
        }
    }

    public function delete($id)
    {
        if($this->Aides_model->deleteAideByID($id))
        {
            setFlashdataMessage($this->session, "Aide supprimée");
        }
        else
        {
            setFlashdataMessage($this->session, "Erreur lors de la suppression de l'aide");
        }
		echo json_encode("OK");
    }

    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueilAdmin(false), new BreadcrumbItem("Aide","/admin/aide", $current));
    }

    private function getBreadcrumbItems($extra_liste_items)
    {
        if(!is_array($extra_liste_items)) $extra_liste_items = [$extra_liste_items];
        return array_merge($this->initBreadcrumbItem(), array_values($extra_liste_items));
    }


}
