<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\UserFavorites;

class UserFavoritesSeeder extends Seeder
{
	public function run()
	{
		$user_favorites = new UserFavorites;

		for ($i = 0; $i < 100; $i++) {
			$user_favorites->save(
				[
					'user_id' 		    =>    1,
					'post_id'			=> 	  $i,
				]
			);
		}
	}
}
