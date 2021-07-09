<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;
use App\Models\Post;
use App\Libraries\Slug;

class PostSeeder extends Seeder
{
	public function run()
	{
		$post = new Post;
		$slug = new Slug;
		$faker = \Faker\Factory::create();

		for ($i = 0; $i < 50; $i++) {
			$post->save(
				[
					'name' 		       	=>    $faker->name,
					'slug'       		=>    $slug->str_slug($faker->name),
					'cat_id'    		=>    rand(1, 10),
					'is_type'    		=>    rand(0, 4),
					'province_id'		=>	  rand(1, 96),
					'district_id'		=>	  rand(1, 973),
					'user_id' 			=>	  rand(1, 63),
					'price'				=> 	  rand(),
					'contact_address'   =>    $faker->text(),
					'video'				=> 	  'https://www.youtube.com/watch?v=dgzOTiZyb9U',
					'video_description' =>    $faker->text(),
					'thumb_list' 		=> 	  \Faker\Provider\Image::imageUrl(640, 480),
					'expire_from'		=>	  '2021-07-04',
					'expire_to'			=>	  '2021-08-03',
					'status'			=>    STATUS_POST_ACTIVE,
					'featured'			=>	  rand(0, 1),
					'meta_description'  =>	  $faker->text(),
					'meta_keyword'  	=>	  $faker->text(),
					'created_at'  		=>    Time::createFromTimestamp($faker->unixTime()),
					'updated_at'  		=>    Time::now()
				]
			);
		}
	}
}
