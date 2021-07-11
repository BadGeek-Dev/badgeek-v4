<?php 
        
defined('BASEPATH') OR exit('No direct script access allowed');
        
class UserUploads extends Badgeek_Controller {
    private $user_dir = "";
    private $list_files = array();
    public function __construct()
    {
        parent::__construct();
        $this->checkIsPodcasteur();
        $this->user_dir = $this->getPrivateDir()."/".$this->user->id;
        //Si le dossier n'existe pas, on le crée
        if(is_dir($this->user_dir))
        {
            //La liste des fichiers
            $this->list_files = scandir($this->user_dir);
            //Nettoyage
            $this->listFilesClean();
            
        }
        else{
            mkdir($this->user_dir);
        }
    }
    
    private function listFilesClean()
    {
        foreach ($this->list_files as $key => $filename) 
        {
            //Suppression des non mp3.
            if(substr($filename, -4) != ".mp3")
            {
                unlink($this->user_dir."/".$filename);       
            }
            //Vérificaion du lien de chaque fichier avec un épisode de podcast
            
        }
    }

    public function index()
    {
                    
    }
        
}
        
    /* End of file  UserUploads.php */
        
                            