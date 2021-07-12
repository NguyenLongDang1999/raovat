<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserFavorites;

class UserFavoritesSeeder extends Seeder
{
	public function run()
	{
		$user_favorites = new UserFavorites;
		$faker = \Faker\Factory::create();

		for ($i = 0; $i < 50; $i++) {
			$user_favorites->save(
				[
					'user_id' 		    =>    1,
					'post_id'			=> 	  rand(1, 50),
				]
			);
		}
	}
}
