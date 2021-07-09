<?php

require_once APPPATH . 'core/Badgeek_Controller.php';

class DevTools extends CI_Controller
{
    const DUMP_PATH = __DIR__.'/../private/dumps';
    const ORIGINAL_IMPORT_FILE = 'dump-initial.sql.gz';
    const GOOD_COOKIE = 'badgeek';
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['badgeek', 'cookie']);
        $this->load->library(['session', 'helper']);
        $this->load->database();
        
    }
    
    public function index()
    {
        $this->checkDevAccount();
        //Liste des dumps
        $liste_dumps = [];
        if ($handle = opendir(DevTools::DUMP_PATH)) {

            while (false !== ($entry = readdir($handle))) {
        
                if ($entry != "." && $entry != ".." && $entry != DevTools::ORIGINAL_IMPORT_FILE) {
                    $liste_dumps[] = $entry;
                }
            }
        
            closedir($handle);
        }
        $this->template->load('private/devtools', array(
            'dumps' => array_reverse($liste_dumps),
            'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true)));
            
    }

    public function check()
    {
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('check_dev_password', 'check_dev_password', 'required');
        if ($this->form_validation->run() === FALSE)
        {
            $this->template->load('private/check', array(
                'liste_BreadcrumbItems' => $this->initBreadcrumbItem(true)));
        }
        else
        {
            $this->checkDevPassword();
        }
        
    }
        
    public function checkDevPassword()
    {
         //Fichier contenant le password en hash256
         $fp = fopen(__DIR__."/../private/check_dev_password", "r");
         $hash_passwd = fgets($fp);
         fclose($fp);
         if($hash_passwd && $hash_passwd == hash("sha256", $this->input->post("check_dev_password")))
         {
            set_cookie("check_dev_password", DevTools::GOOD_COOKIE, 3600);
         }
         else
         {
            setFlashdataMessage($this->session,'Vous n\'avez pas les droits d\'accès','top-right');
         }
         redirect('devtools', 'refresh');
    }
    
    
    
    private function initBreadcrumbItem($current = false)
    {
        return array(BreadcrumbItem::getBreadcrumbItemAccueilAdmin(false), new BreadcrumbItem("DevTools","/devtools", $current));
    }
    
    function dump($redirect = true)
    {
        $this->checkDevAccount();
        // Load the DB utility class
        $this->load->dbutil();

        // Backup your entire database and assign it to a variable
        $backup = $this->dbutil->backup();

        // Load the file helper and write the file to your server
        $this->load->helper(['file', 'date']);
        $filename = DevTools::DUMP_PATH.'/dump_bdd_'.date("Y-m-d-H-i-s").'.gz';
        write_file($filename, $backup);
        if($redirect) 
        {
            redirect("/devtools", 'refresh');
        }
    }

    function importdump($filename, $delete_gz= true) {
        $this->checkDevAccount();
        $path_gz = DevTools::DUMP_PATH."/".$filename;
        $path_sql = $path_gz.".sql";
        file_put_contents($path_sql, gzdecode(file_get_contents($path_gz)));
        $file_restore = $this->load->file($path_sql, true);
        $file_array = preg_split("/;(\n|\r\n)/", $file_restore);
        foreach ($file_array as $query)
        {
            if(preg_match('(INSERT|CREATE|DROP|UPDATE)', $query) === 1)
            {
                $this->db->query("SET FOREIGN_KEY_CHECKS = 0");
                $this->db->query($query);
                $this->db->query("SET FOREIGN_KEY_CHECKS = 1");
            }
        }
        $this->load->helper('file');
        if($delete_gz) unlink($path_gz);
        unlink($path_sql);
        setFlashdataMessage($this->session,'Dump restoré','top-right');
        redirect("/devtools", 'refresh');
    }
    function forcedownload($filename)
    {
        $this->checkDevAccount();
        // Load the download helper and send the file to your desktop
        $this->load->helper('download');
        $path_gz = DevTools::DUMP_PATH."/".$filename;
        force_download($filename, $path_gz);
    }
    function deletedump($filename)
    {
        $this->checkDevAccount();
        unlink(DevTools::DUMP_PATH."/".$filename);
        redirect("/devtools", 'refresh');
    }
    function raz()
    {
        $this->checkDevAccount();
        $this->dump(false);
        $this->importdump(DevTools::ORIGINAL_IMPORT_FILE, false);
    }

    public function checkDevAccount()
    {
        $good_cookie = DevTools::GOOD_COOKIE;
        if(get_cookie("check_dev_password") == $good_cookie)
        {
            set_cookie("check_dev_password", $good_cookie, 3600);
        }
        else
        {
           redirect("devtools/check");
        }
    }


}