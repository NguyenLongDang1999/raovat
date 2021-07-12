<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserGroupSeeder extends Seeder
{
	public function run()
	{
		$this->db->query("INSERT INTO `auth_groups` (`id`, `name`, `description`) VALUES
		(1, 'super-admin', 'Super Administrator'),
		(2, 'user', 'User'),
		(3, 'admin', 'Admin'),
		(4, 'manager', 'Manager')
		");
	}
}
