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
        $template_data['user'] = $this->CI->ion_auth->user()->row();
        $template_data['sid'] = refreshSid();
        $template_data['extras']['js'] = 'assets/js/header.js';

        $this->set('contents' , $this->CI->load->view($view, $view_data, TRUE));
        
        $this->CI->load->view('layouts/'.$layout, $this->template_data);
    }
                               
}