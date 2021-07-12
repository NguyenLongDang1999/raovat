<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use Myth\Auth\Models\UserModel;

class User extends Seeder
{
	public function run()
	{
		$user = new UserModel;
		$config = config('Auth');
		$faker = \Faker\Factory::create();

		$hashOptions = [
			'cost' => $config->hashCost
		];

		$password_hash = password_hash(
			base64_encode(
				hash('sha384', $faker->password, true)
			),
			$config->hashAlgorithm,
			$hashOptions
		);

		for ($i = 1; $i <= 50; $i++) {
			$user->save(
				[
					'fullname'        	=>    $faker->name,
					'email'       		=>    $faker->email,
					'password_hash'    	=>    $password_hash,
					'phone'       		=>    $faker->phoneNumber,
					'avatar' 			=> 	  $faker->imageUrl(140, 140),
					'gender' 			=> 	  rand(GENDER_FEMALE, GENDER_MALE),
					'active'			=> 	  1,
				]
			);
		}
	}
}
