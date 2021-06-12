<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBannerTable extends Migration
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
			'name'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'url'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'description'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null' 		 => true,
			],
			'image'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
			],
			'cat_id'       => [
				'type'       => 'INT',
				'constraint' => '11',
			],
			'orders'       => [
				'type'       => 'INT',
				'constraint' => '1',
				'default'    => '1',
			],
			'status'       => [
				'type'       => 'INT',
				'constraint' => '1',
				'default'    => '1',
			],
			'created_at'       => [
				'type'       => 'DATETIME',
				'null' => true
			],
			'updated_at'       => [
				'type'       => 'DATETIME',
				'null' => true
			],
			'deleted_at'       => [
				'type'       => 'DATETIME',
				'null' 		 => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('banner');
	}

	public function down()
	{
		$this->forge->dropTable('banner');
	}
}
