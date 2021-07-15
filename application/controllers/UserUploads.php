<?php 
        
require_once APPPATH . 'core/Badgeek_Controller.php'; 
        
class UserUploads extends Badgeek_Controller {
    private $user_dir = "";
    private $list_files = array();
    public function __construct()
    {
        parent::__construct();
        $this->checkIsPodcasteur();
        $this->load->library("helper");
        $this->user_dir = $this->getPrivateDir()."/".$this->user->id;
        //Si le dossier n'existe pas, on le crée
        if(is_dir($this->user_dir))
        {
            //Nettoyage
            $this->listFilesClean();
            //La liste des fichiers
            $this->list_files = array_filter(scandir($this->user_dir), function($file) {
                return is_file($this->user_dir."/".$file);
            });
            
        }
        else{
            mkdir($this->user_dir);
        }
    }
  
    private function listFilesClean()
    {
        foreach ($this->list_files as $key => $filename) 
        {
            $filepath = $this->user_dir."/".$filename;
            //Suppression des non mp3.
            if(substr($filename, -4) == ".mp3")
            {
                //Si un mp3 dépasse la limite, on le supprime.
                $dt = new DateTime();
                $dt->setTimestamp(filemtime($filepath));
                $nb_days_diff = intval($dt->diff(new DateTime())->format("%d"));
                //TODO : Préférence utilisateur/site par admin à créér 
                $nb_days_diff_max = 30;
                if($nb_days_diff > $nb_days_diff_max)
                {
                    unlink($filepath);
                }
                
            }
            else
            {
                unlink($filepath);       

            }
            
        }
    }

    public function index()
    {
        $liste_files = [];
        foreach($this->list_files as $key => $filename)
        {
            array_push($liste_files, [
                    "caption" => $filename,
                    "size" => $this->helper->formatSizeUnits(filesize($this->user_dir."/".$filename)),
                    "path" => 'assets/private/'.$this->user->id.'/'.$filename
                ]);
        }
        $this->template->load('user/uploads', [
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true),
            'liste_files' => $liste_files
        ]);           
    }

    public function upload()
    {
        $this->checkIsPodcasteur();
        if(move_uploaded_file($_FILES['file']['tmp_name'],$this->getPrivateDir()."/".$this->user->id."/".$_FILES['file']['name']))
        {
            setFlashdataMessage($this->session, "Fichier uploadé.");
        }

        return json_encode("ok");
    }

    public function delete()
    {
        $this->checkIsPodcasteur();
        $path = $this->input->post("path"); 
        $dirs = explode("/", $path);
        $filename = array_pop($dirs);
        $id_user = array_pop($dirs);
        $filepath = $this->getPrivateDir()."/".$id_user."/".$filename;
        if($id_user != $this->user->id)
        {
            $this->goBackError("Opération non autorisée" , "/uploads");
        }
        if(is_file($filepath))
        {
            unlink($filepath);
            setFlashdataMessage($this->session, "Fichier supprimé");
        }
        echo json_encode("OK");
    }

    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueil(), new BreadcrumbItem("Mes uploads", "/myuploads", $current));
    }
        
}
        
    /* End of file  UserUploads.php */
        
                            