<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Archivage_Podcast extends CI_Migration {

    public function up()
    {
        $this->dbforge->add_column('podcasts',['archive' => ['type' => 'TINYINT']]);
    }

    public function down()
    {
        $this->dbforge->drop_column('podcasts', 'archives');
    }
}
