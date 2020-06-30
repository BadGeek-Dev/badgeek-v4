<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_Live extends CI_Migration {


    public function up()
    {
        $fields = array(
            'id' => array('type' => 'INT',
                'auto_increment' => TRUE,
                'unique'=> TRUE),
            'id_member' => array('type' => 'INT'),
            'title' => array('type' => 'VARCHAR',
                'constraint' => '255',
                'null' => TRUE),
            'content' => array('type' => 'VARCHAR',
                'constraint' => '3000',
                'null' => TRUE),
            'created_at' => array('type' => 'DATETIME'),
            'start_at' => array('type' => 'DATETIME'),
            'status' =>array('type' => 'BOOL'),
            'url' =>array('type' => 'VARCHAR',
                'constraint' => '255')
        );

        $this->dbforge->add_field($fields);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('lives');
    }

    public function down()
    {
        $this->dbforge->drop_table('lives');
    }
}