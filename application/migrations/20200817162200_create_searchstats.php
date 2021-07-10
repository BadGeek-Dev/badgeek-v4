<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Create_Searchstats extends CI_Migration {

    public function up()
    {
        $fields = array(
            'id' => array('type' => 'INT',
                'auto_increment' => TRUE,
                'unique'=> TRUE),
            'query' => array(
                'type' => 'VARCHAR',
                'constraint' => '3000',
                'null' => TRUE),
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('searchstats', TRUE);
    }

    public function down()
    {
        $this->dbforge->drop_table('searchstats');
    }
}