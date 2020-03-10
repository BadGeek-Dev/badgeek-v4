<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_add_picture_AdminNews extends CI_Migration {

    public function up()
    {
        $fields = array(
            'picture' => array('type' => 'VARCHAR',
                'constraint' => '255')
        );

        $this->dbforge->add_column('articles',$fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('articles','picture');
    }
}