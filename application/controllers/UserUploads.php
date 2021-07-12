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
            $this->list_files = array_filter(scandir($this->user_dir), "is_file");
            
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
            $filepath = $this->user_dir."/".$filename;
            array_push($liste_files, [
                    "caption" => $filename,
                    "size" => $this->helper->formatSizeUnits(filesize($filepath)),
                    "url" => base_url($filepath), 
                    "key" => $key
                ]);
        }
        $this->template->load('user/uploads', [
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true),
            'liste_files' => $liste_files
        ]);           
    }

    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueil(), new BreadcrumbItem("Mes uploads", "/uploads", $current));
    }
        
}
        
    /* End of file  UserUploads.php */
        
                            