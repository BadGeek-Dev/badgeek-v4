<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_AdminNews extends CI_Migration {

    public function up()
    {
        $fields = array(
            'valid' => array('type' => 'BOOL')
        );

        $this->dbforge->add_column('podcasts', $fields);
    }

    public function down()
    {
    }
}