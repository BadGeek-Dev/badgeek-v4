<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Helper {
    private $CI;

    public function __construct() 
    {
        $this->CI =& get_instance();
    }

    public function numero($saison, $numero)
    {
        return str_pad($saison, 5, "0", STR_PAD_LEFT).'_'.str_pad($numero,5,"0", STR_PAD_LEFT);
    }

    public function numero_inverse($numero)
    {
        list($saison, $numero) = explode('_', $numero);
        return [
            ltrim($saison, '0'),
            ltrim($numero, '0')
        ];
    }
}


