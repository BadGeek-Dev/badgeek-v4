<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_hosted_type_podcast_valid_episode extends CI_Migration {

    public function up()
    {
        $fields = array(
            'hosted' => array('type' => 'BOOL')
        );
        $this->dbforge->add_column('podcasts', $fields);

        $fields = array(
            'valid' => array('type' => 'BOOL')
        );
        $this->dbforge->add_column('episodes', $fields);
    }

    public function down()
    {
        $this->dbforge->add_column('podcasts', 'hosted');
        $this->dbforge->add_column('episodes', 'valid');

    }
}