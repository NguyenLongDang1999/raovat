<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserFavoritesTable extends Migration
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
			'created_at'       => [
				'type'       => 'DATETIME',
				'null' => true
			],
			'updated_at'       => [
				'type'       => 'DATETIME',
				'null' => true
			]
		]);
		$this->forge->addKey('id', true);
		$this->forge->createTable('users_favorites');
	}

	public function down()
	{
		$this->forge->dropTable('users_favorites');
	}
}
