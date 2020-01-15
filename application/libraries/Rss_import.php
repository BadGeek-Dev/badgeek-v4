<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rss_import {
    private $CI;

    private $podcast;

    private $episodes;

    private $titles = [];

    public function __construct() 
    {
        $this->CI =& get_instance();
        $this->CI->load->library('rss_parser', [$this, 'parseFile']);
        $this->CI->load->model('episodes_model');
    }      
    
    public function sync($podcast)
    {
        $this->podcast = $podcast;
        $this->episodes = $this->CI->episodes_model->findByPodcast($podcast);

        foreach ($this->episodes as $episode) {
            $this->titles[] = $episode->titre;
        }

        try {
            $rss = $this->CI->rss_parser->set_feed_url($this->podcast->rss)->set_cache_life(30)->getFeed(-1);
        } catch (\Throwable $th) {
            return 'RSS error';
        }

        foreach ($rss as $item)
        {
            $this->importEpisode($item);
        }

        return true;
    }

    /**
     * 
     */
    private function importEpisode($item)
    {
        if (!in_array($item['title'], $this->titles)) {
            $this->createEpisode($item);
        }   
    }

    /**
     * 
     */
    private function createEpisode($item)
    {
        $this->CI->episodes_model->refresh();
        
        $this->CI->episodes_model->setNumero('');
        $this->CI->episodes_model->setTitre($item['title']);
        $this->CI->episodes_model->setDescription($item['description']);
        $this->CI->episodes_model->setDate_publication($item['pubDate']);
        $this->CI->episodes_model->setLien_mp3($item['media']);
        $this->CI->episodes_model->setInfos_mp3('');
        $this->CI->episodes_model->setTags('');
        $this->CI->episodes_model->setId_podcast($this->podcast->id);

        $this->CI->episodes_model->insert();
    }


    public static function parseFile($data, $item)
	{
        $data['media'] = (string)$item->enclosure->attributes()['url'];
		return $data;
	}
}