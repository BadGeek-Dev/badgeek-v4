<?php if (!defined('BASEPATH')) exit("No direct script access allowed");

class Migrate extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        $this->input->is_cli_request() 
            or redirect('/');

        $this->load->library('migration');
    }

    /**
     * call with php index.php migrate
     */
    public function index()
    {
        if(!$this->migration->latest()) {
            show_error($this->migration->error_string());
        }
    }
}