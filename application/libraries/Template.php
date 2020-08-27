<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Template {
    private $CI;
    var $template_data = [];

    public function __construct() 
    {
        $this->CI =& get_instance();
        $this->CI->load->model('podcasts_model');
    }

    function set($content_area, $value)
    {
        $this->template_data[$content_area] = $value;
    }

    function exists($content_area)
    {
        return key_exists($content_area, $this->template_data) && $this->template_data[$content_area];
    }

    function isEmpty($content_area)
    {
        return !$this->exists($content_area);
    }

    function load($view, $view_data = [], $layout = 'default_layout')
    {
        $this->set('user', $this->CI->ion_auth->user()->row());
        $this->set('sid', $_SESSION["sid"] = rand(0, time()));
        $header_js_file = 'assets/js/header.js';
        $this->set('extras', ['js' => [$header_js_file.'?'.filemtime($header_js_file)]]);
        $this->set('contents', $this->CI->load->view($view, $view_data, TRUE));
        //Gestion fil d'ariane
        if($this->isEmpty('breadcrumb') && key_exists('liste_BreadcrumbItems', $view_data) && is_array($view_data['liste_BreadcrumbItems']))
        {
            $this->set('breadcrumb', new Breadcrumb($view_data['liste_BreadcrumbItems']));
        }
        //Chargement du layout
        $this->CI->load->view('layouts/'.$layout, $this->template_data);
    }

    function load_admin($view, $view_data = [])
    {
        if(key_exists('liste_BreadcrumbItems', $view_data) && is_array($view_data['liste_BreadcrumbItems']))
        {
            $this->set('breadcrumb', new Breadcrumb($view_data['liste_BreadcrumbItems']));
        }
        $this->inject_admin_data($view_data);
        $this->set('contents_admin', $this->CI->load->view($view, $view_data, TRUE));
        $this->load('layouts/admin_layout',$this->template_data);
    }

    function inject_admin_data(&$view_data)
    {
        $view_data['waiting_podcasts'] = count($this->CI->podcasts_model->findByValid(0));
    }
}