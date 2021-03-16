<?php

require_once APPPATH . 'core/Badgeek_Controller.php'; 

class Badgeek extends Badgeek_Controller
{
    public function index()
    {
        $this->load->model('Config_model');
        
        //Initialisation du site
        $init_file = realpath(__DIR__."/../config/badgeek.init");
        if(file_exists($init_file))
        {
            $this->load->library('email_manager');
            if($this->Config_model->init())
            {
                unlink($init_file);
                $this->email_manager->sendMessageToAdmins("Initialisation du site effectuée", "OK");
            }
            else
            {
                $this->email_manager->sendErrorMailToAdmins("Initialisation foirée");

            }
        }
        $this->load->model('Podcasts_model');
        $this->load->model('Episodes_model');
        $this->load->model('Articles_model');

        $this->template->load(
            'public/index', 
            [
                "news" => $this->Articles_model->getFirstArticlesVisibles(getConfig("nb_articles_homepage")) ?: [], // getAllArticlesVisible(),
                "podcasts" => $this->Podcasts_model->findLastValidated(),
                "episodes" => $this->Episodes_model->findLastValidated(),
                "btnStatus" => $this->Articles_model->isPreviousNextArticleVisible(),
                "liste_BreadcrumbItems" => [
                    BreadcrumbItem::getBreadcrumbItemAccueil(true)
                    ]
            ]);
    }
    
    public function getNews($id,$side)
    {
        $this->load->model('Articles_model');
        $result = $this->Articles_model->getArticleBySide($id,$side);
        $article = $result['article'];
        $html="
            <h3>{$article->title}</h3>
            <p class='font-italic text-secondary'>
                par {$article->username} le {$article->created_at}
            </p>
            <div class='row'>
            ".($article->picture ? "<img class='mr-4' src='".base_url('assets/pictures/news/'.$article->picture)."'/>" : "")."
                <p>{$article->content}</p>
            </div>";
        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode(array('html' => $html,"btnStatus" => $result['btnStatus'],'currentID'=>$article->id)));
    }
}
