<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$config = array(
    'admin/addArticle' => array(
        array(
            'field' => 'title',
            'label' => 'Titre',
            'rules' => 'required|htmlspecialchars'
        ),
        array(
            'field' => 'content',
            'label' => 'Contenu',
            'rules' => 'required|htmlspecialchars'
        )
    ),
    'admin/editArticle' => array(
        array(
            'field' => 'title',
            'label' => 'Titre',
            'rules' => 'required|htmlspecialchars'
        ),
        array(
            'field' => 'content',
            'label' => 'Contenu',
            'rules' => 'required|htmlspecialchars'
        )
    )
);
