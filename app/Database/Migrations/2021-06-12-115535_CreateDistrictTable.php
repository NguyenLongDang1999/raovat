<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDistrictTable extends Migration
{
	public function up()
	{
		$this->forge->addField([
			'id'          => [
				'type'           => 'INT',
				'constraint'     => 11,
				'unsigned'       => true,
				'auto_increment' => true,
			],
			'name'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 100,
			],
			'type'          => [
				'type'           => 'VARCHAR',
				'constraint'     => 30,
			],
			'provinceid'          => [
				'type'           => 'INT',
				'constraint'     => 5
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('district');
	}

	public function down()
	{
		$this->forge->dropTable('district');
	}
}
