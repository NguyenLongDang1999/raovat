<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateProvinceTable extends Migration
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
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('province');
	}

	public function down()
	{
		$this->forge->dropTable('province');
	}
}
