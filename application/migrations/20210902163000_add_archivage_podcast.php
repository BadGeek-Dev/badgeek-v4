<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Add_Archivage_Podcast extends CI_Migration {

    public function up()
    {
        $fields = array(
            'archive' => array('type' => 'TINYINT')
        );

        $this->dbforge->add_column('podcasts',$fields);
    }

    public function down()
    {
        
    }
}
