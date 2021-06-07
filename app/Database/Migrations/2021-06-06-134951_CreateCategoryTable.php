<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoryTable extends Migration
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
			'slug'       => [
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
				'null' 		 => true,
			],
			'parent_id'       => [
				'type'       => 'INT',
				'constraint' => '11',
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
			'meta_description'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null' 		 => true,
			],
			'meta_keyword'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null' 		 => true,
			],
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('category');
	}

	public function down()
	{
		$this->forge->dropTable('category');
	}
}
