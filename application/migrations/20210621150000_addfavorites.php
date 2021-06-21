<?php


defined('BASEPATH') or exit('No direct script access allowed');

class Migration_Add_Config extends CI_Migration
{

	public function up()
	{
		$fields = array(
			'id' => array('type' => 'INT',
				'auto_increment' => TRUE,
				'unique'=> TRUE),
			'id_user' => array('type' => 'INT'),
			'favorites' => array('type' => 'VARCHAR',
				'constraint' => '3000',
				'null' => TRUE),
		);

		$this->dbforge->add_field($fields);
		$this->dbforge->add_key('id', TRUE);
		$this->dbforge->create_table('favoris');
	}

	public function down()
	{
		$this->dbforge->drop_table('favoris');
	}
}
