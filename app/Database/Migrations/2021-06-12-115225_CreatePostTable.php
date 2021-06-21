<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePostTable extends Migration
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
			'cat_id'       => [
				'type'       => 'INT',
				'constraint' => '11',
			],
			'is_type'       => [
				'type'       => 'TINYINT',
				'constraint' => '1',
			],
			'province_id'       => [
				'type'       => 'INT',
				'constraint' => '11',
			],
			'district_id'       => [
				'type'       => 'INT',
				'constraint' => '11',
			],
			'user_id'       => [
				'type'       => 'INT',
				'constraint' => '11',
			],
			'price'       => [
				'type'       => 'BIGINT',
				'constraint' => '11',
				'null' => true,
				'default'    => '0',
			],
			'contact_address'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null' => true
			],
			'video'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null' => true
			],
			'video_description'       => [
				'type'       => 'VARCHAR',
				'constraint' => '255',
				'null' => true
			],
			'thumb_list'       => [
				'type'       => 'TEXT',
				'null' => true
			],
			'description'       => [
				'type'       => 'LONGTEXT',
			],
			'expire_from'       => [
				'type'       => 'DATE',
				'null' => true
			],
			'expire_to'       => [
				'type'       => 'DATE',
				'null' => true
			],
			'status'       => [
				'type'       => 'INT',
				'constraint' => '1',
				'default'    => '1',
			],
			'view'       => [
				'type'       => 'INT',
				'constraint' => '1',
				'default'    => '0',
			],
			'featured'       => [
				'type'       => 'TINYINT',
				'constraint' => '1',
				'default'    => '0',
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
		$this->forge->createTable('post');
	}

	public function down()
	{
		$this->forge->dropTable('post');
	}
}
