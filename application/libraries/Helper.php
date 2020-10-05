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

    /**
     * 
     */
    public function get_user_prefs()
    {
        return json_decode($this->CI->user->prefs, TRUE);
    }

    /**
     * 
     */
    public function set_user_prefs(array $prefs)
    {
        $this->CI->load->model('users_model');

        $this->CI->user->prefs = json_encode($prefs);

        $user_to_save = $this->CI->user;
        unset($user_to_save->user_id);
        unset($user_to_save->avatar);

        $this->CI->users_model->update($this->CI->user);

        return $this->CI->user;
    }
}


