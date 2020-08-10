<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mp3_info {
    private $CI;

    private $getID3;

    public function __construct() 
    {
        $this->CI =& get_instance();
        $this->getID3 = new getID3;
    }

    public function analyze($mp3)
    {
        return $this->getID3->analyze($mp3);
    }
}


