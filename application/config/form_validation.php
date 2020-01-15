<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'admin/addArticle' => array(
        array(
            'field' => 'title',
            'label' => 'Titre',
            'rules' => 'required'
        ),
        array(
            'field' => 'content',
            'label' => 'Contenu',
            'rules' => 'required'
        )
    )
);
