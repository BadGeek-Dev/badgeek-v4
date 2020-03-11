<?php

require_once APPPATH . 'core/Badgeek_Controller.php'; 

class Badgeek extends Badgeek_Controller
{
    public function index()
    {
        $this->load->model('Articles_model');
        $result = $this->Articles_model->getFirstArticleVisible();
       $btnStatus = $this->Articles_model->isPreviousNextArticleVisible();

        $this->template->load('public/index', array("result" => $result, "btnStatus" => $btnStatus));
    }

    public function getNews($id,$side){

        $this->load->model('Articles_model');
        $result = $this->Articles_model->getArticleBySide($id,$side);
        $article = $result['article'][0];
        $btnStatus = array($result['btnStatus']);
        $html=' <h3>'.$article->title.'</h3><p class="font-italic text-secondary"> par '.$article->username.' le '.$article->created_at.'</p><p>'.$article->content.'</p>';
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('html' => $html,"btnStatus" => $btnStatus[0],'currentID'=>$article->id)));

    }
}
