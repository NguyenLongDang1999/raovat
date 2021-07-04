<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateTableUser extends Migration
{
	public function up()
	{
		$forge = \Config\Database::forge();

		$fields = [
			'avatar'           		=> ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'phone'            		=> ['type' => 'varchar', 'constraint' => 255],
			'fullname'				=> ['type' => 'varchar', 'constraint' => 255],
			'new_email'             => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'gender'           		=> ['type' => 'tinyint', 'constraint' => 1, 'default' => 1],
			'job' 					=> ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
			'address' 				=> ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
			'birthdate' 			=> ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
			'provider_name'         => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
			'provider_uid'          => ['type' => 'varchar', 'constraint' => 255, 'null' => true],
		];

		$forge->addColumn('users', $fields);
	}

	public function down()
	{
		$this->forge->dropTable('users');
	}
}