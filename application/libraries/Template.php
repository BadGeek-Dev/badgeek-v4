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
        $this->set('user', $this->CI->ion_auth->user()->row());
        $this->set('sid', $_SESSION["sid"] = rand(0, time()));
        $this->set('extras', ['js' => ['assets/js/header.js']]);
        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));

        $this->CI->load->view('layouts/'.$layout, $this->template_data);
    }

    function load_admin($view, $view_data = [])
    {
        $this->set('contents_admin', $this->CI->load->view($view, $view_data, TRUE));
        $this->load_main('layouts/admin_layout',$this->template_data);

    }
//
    function load_main($view, $view_data = [],   $layout = 'default_layout')
    {
        $this->set('user', $this->CI->ion_auth->user()->row());
        $this->set('sid', $_SESSION["sid"] = rand(0, time()));
        $this->set('extras', ['js' => ['assets/js/header.js']]);
        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
        $this->CI->load->view('layouts/'.$layout, $this->template_data);
    }
}