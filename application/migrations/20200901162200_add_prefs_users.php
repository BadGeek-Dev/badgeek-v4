<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_prefs_users extends CI_Migration {

    public function up()
    {
        $fields = array(
            'prefs' => array('type' => 'TEXT')
        );

        $this->dbforge->add_column('users',$fields);
    }

    public function down()
    {
        
    }
}