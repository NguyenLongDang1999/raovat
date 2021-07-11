<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
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
					'created_at'  		=>    Time::createFromTimestamp($faker->unixTime()),
					'updated_at'  		=>    Time::now()
				]
			);
		}
	}
}
