<?php

require_once APPPATH . 'core/Badgeek_Controller.php'; 

class Badgeek extends Badgeek_Controller
{
    public function index()
    {
        $this->load->model('Articles_model');
        $result = $this->Articles_model->getFirstArticleVisible();
        if($this->Articles_model->multipleArticleVisible() ) {
            $nextID = $this->Articles_model->getNextArticleVisibleID(0);
        }
        $this->template->load('public/index', array("result" => $result, "nextID" => $nextID));
    }

    public function getNews($id){
        $this->load->model('Articles_model');
        $article = $this->Articles_model->getArticleByID($id);
        $nextID = $this->Articles_model->getNextArticleVisibleID($id);
        $previousID = $this->Articles_model->getPreviousArticleVisibleID($id);
        $html=' <h3>'.$article->title.'</h3><p class="font-italic text-secondary"> par '.$article->username.' le '.$article->created_at.'</p><p>'.$article->content.'</p>';
        echo json_encode(array('html' => $html, 'previousID' => $previousID, 'nextID' => $nextID));

    }
}
