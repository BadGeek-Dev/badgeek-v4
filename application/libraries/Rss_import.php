<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rss_import {
    private $CI;

    public function __construct() 
    {
        $this->CI =& get_instance();
        $this->CI->load->library('rss_parser', [$this, 'parseFile']);
    }      
    
    public function sync($podcast)
    {
        try {
            $rss = $this->CI->rss_parser->set_feed_url('http://feeds.feedburner.com/lerendezvoustech')->set_cache_life(30)->getFeed(-1);
        } catch (\Throwable $th) {
            return 'RSS error';
        }

        foreach ($rss as $item)
        {
            $this->importEpisode($item, $podcast);
        }

        return true;
    }

    private function importEpisode($item, $podcast)
    {
        //exist or add
        $this->CI->load->model('episodes_model');

        //create
        $this->createEpisode($item, $podcast);
    }

    /**
     * 
     */
    private function createEpisode($item, $podcast)
    {
        $this->CI->episodes_model->refresh();
        
        $this->CI->episodes_model->setNumero('');
        $this->CI->episodes_model->setTitre($item['title']);
        $this->CI->episodes_model->setDescription($item['description']);
        $this->CI->episodes_model->setDate_publication($item['pubDate']);
        $this->CI->episodes_model->setLien_mp3($item['media']);
        $this->CI->episodes_model->setInfos_mp3('');
        $this->CI->episodes_model->setTags('');
        $this->CI->episodes_model->setId_podcast($podcast->id);

        $this->CI->episodes_model->insert();
    }


    public static function parseFile($data, $item)
	{
        $data['media'] = (string)$item->enclosure->attributes()['url'];
		return $data;
	}
}