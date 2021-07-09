<?php

require_once APPPATH . 'core/Badgeek_Controller.php';

class DevTools extends CI_Controller
{
    const DUMP_PATH = __DIR__.'/../private/dumps';
    const ORIGINAL_IMPORT_FILE_PATH = __DIR__. '/../../assets';
    const ORIGINAL_IMPORT_FILE = 'dump-initial.sql.gz';
    const GOOD_COOKIE = 'badgeek';
    public function __construct()
    {
        parent::__construct();
        $this->load->helper(['badgeek', 'cookie']);
        $this->load->library(['session', 'helper', 'migration']);
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
        //Migrations
        $this->template->load('private/devtools', array(
            'dumps' => array_reverse($liste_dumps),
            'migration_courante' => $this->migration->_get_version(),
            'migrations' => $this->migration->find_migrations(),
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

    function importdump($filename, $delete_gz= true,  $refresh = true) {
        $this->checkDevAccount();
        $path_gz = ($filename == DevTools::ORIGINAL_IMPORT_FILE ? DevTools::ORIGINAL_IMPORT_FILE_PATH : DevTools::DUMP_PATH)."/".$filename;
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
        if($refresh) redirect("/devtools", 'refresh');
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
    function raz($refresh = true)
    {
        $this->checkDevAccount();
        $this->dump(false);
        $this->importdump(DevTools::ORIGINAL_IMPORT_FILE, false, $refresh);
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
    
    public function migration($method, $version)
    {
        $this->checkDevAccount();
        if($method == "up")
        {
            $file = $this->migration->find_migrations()[$version];
            $version_precedente = 0;
        }
        else
        {
            $migrations = $this->migration->find_migrations();
            foreach($migrations as $migration_version => $file)
            {
                if($migration_version < $version)
                {
                    $version_precedente = $migration_version;
                } 
                else if ($migration_version == $version)
                {
                    continue;
                }
                else
                {
                    return false;
                }
            }
        }
        include_once($file);
        $class = 'Migration_'.ucfirst(strtolower($this->migration->_get_migration_name(basename($file, '.php'))));
        // Validate the migration file structure
        if ( ! class_exists($class, FALSE))
        {
            $this->_error_string = sprintf($this->lang->line('migration_class_doesnt_exist'), $class);
            return FALSE;
        }
        elseif ( ! is_callable(array($class, $method)))
        {
            $this->_error_string = sprintf($this->lang->line('migration_missing_'.$method.'_method'), $class);
            return FALSE;
        }
        $migration = array($class, $method);
        $migration[0] = new $migration[0];
        call_user_func($migration);
        $this->migration->_update_version($version_precedente ?: $version);
        setFlashdataMessage($this->session,"Migration " . $class." ".($method == "up" ? "passée" : "annulée"),'top-right');
        redirect("/devtools", 'refresh');

    }

    function greatreset()
    {
        $this->checkDevAccount();
        $this->raz(false);
        $this->migration->_update_version(1);
        $this->migration->latest();
        redirect("/devtools", 'refresh');
    }

}