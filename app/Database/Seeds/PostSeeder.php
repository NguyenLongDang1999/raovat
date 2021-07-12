<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\Test\Fabricator;
use App\Models\Post;

class PostSeeder extends Seeder
{
	public function run()
	{
		$post = new Post;
		$faker = \Faker\Factory::create();

		for ($i = 1; $i <= 200; $i++) {
			$post->save(
				[
					'name' 		       	=>    $faker->name(),
					'slug'       		=>    $faker->slug(),
					'cat_id'    		=>    rand(1, 132),
					'is_type'    		=>    rand(0, 4),
					'province_id'		=>	  79,
					'district_id'		=>	  785,
					'user_id' 			=>	  rand(1, 51),
					'price'				=> 	  rand(),
					'contact_address'   =>    $faker->text(),
					'description'		=>	  $faker->randomHtml(),
					'video'				=> 	  'https://www.youtube.com/watch?v=3ufQGXG9aNY',
					'video_description' =>    $faker->text(),
					'thumb_list' 		=> 	  $faker->imageUrl(350, 250),
					'expire_from'		=>	  '2021-07-12',
					'expire_to'			=>	  '2021-07-19',
					'status'			=>    STATUS_POST_ACTIVE,
					'featured'			=>	  rand(0, 1),
					'meta_description'  =>	  $faker->text(),
					'meta_keyword'  	=>	  $faker->text(),
				]
			);
		}
	}
}
