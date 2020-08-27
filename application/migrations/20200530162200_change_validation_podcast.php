<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_change_validation_podcast extends CI_Migration {

    public function up()
    {
        $fields = array(
            'valid' => array(
                    'name' => 'valid',
                    'type' => 'INT',
            ),
        );
        $this->dbforge->modify_column('podcasts', $fields);
    }

    public function down()
    {
    }
}