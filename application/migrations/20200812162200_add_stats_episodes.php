<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_stats_episodes extends CI_Migration {

    public function up()
    {
        $fields = array(
            'stats' => array('type' => 'TEXT')
        );

        $this->dbforge->add_column('episodes',$fields);
    }

    public function down()
    {
    }
}