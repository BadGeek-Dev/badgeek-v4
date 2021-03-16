<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Config extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_field("id")
            ->add_field(["nb_articles_homepage" => ['type' => 'INT', 'default' => 1]])
            ->create_table('config');
    }

    public function down()
    {
        $this->dbforge->drop_table('config');
    }
}