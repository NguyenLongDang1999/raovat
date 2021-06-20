<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCommentTable extends Migration
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
			'user_id'       => [
				'type'       => 'INT',
				'constraint' => '11',
			],
			'post_id'       => [
				'type'       => 'INT',
				'constraint' => '11',
			],
			'body'       => [
				'type'       => 'TEXT',
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
		$this->forge->createTable('comment');
	}

	public function down()
	{
		$this->forge->dropTable('comment');
	}
}
