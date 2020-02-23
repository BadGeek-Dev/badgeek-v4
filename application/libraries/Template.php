<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template {
    private $CI;
    var $template_data = [];

    public function __construct() 
    {
        $this->CI =& get_instance();
    }

    function set($content_area, $value)
    {
        $this->template_data[$content_area] = $value;
    }

    function load($view, $view_data = [], $layout = 'default_layout')
    {
        $_SESSION["sid"] = rand(0, time());
        $this->set('user', $this->CI->ion_auth->user()->row());
        $this->set('sid', $_SESSION["sid"]);
        $this->set('extras', ['js' => ['assets/js/header.js']]);
        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
        //Gestion fil d'ariane
        $trace = debug_backtrace();
        $caller = $trace[1];
        $this->set('breadcrumb', Breadcrumb::constructFromCaller($caller));
        //Chargement du layout
        $this->CI->load->view('layouts/'.$layout, $this->template_data);
    }
                               
}