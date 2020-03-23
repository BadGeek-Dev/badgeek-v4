<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_hosted_type_podcast extends CI_Migration {

    public function up()
    {
        $fields = array(
            'hosted' => array('type' => 'BOOL')
        );
        $this->dbforge->add_column('podcasts', $fields);
    }

    public function down()
    {
    }
}