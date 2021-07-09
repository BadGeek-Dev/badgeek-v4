<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_validation_podcast extends CI_Migration {

    private $column_name = 'valid';

    public function up()
    {
        
        $this->dbforge->add_column('podcasts',  array(
            $this->column_name => array('type' => 'BOOL')));
    }

    public function down()
    {
        $this->dbforge->drop_column('podcasts', $this->column_name);
    }
}