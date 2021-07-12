<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
	public function run()
	{
		$category = new Category;
		$faker = \Faker\Factory::create();

		// Parent ROOT
		for ($i = 1; $i <= 10; $i++) {
			$category->save(
				[
					'name' 		       	=>    'Danh mục 12.' . $i,
					'slug'       		=>    $faker->slug(),
					'description'		=>	  $faker->text(),
					'image'				=>	  $faker->imageUrl(100, 100),
					'parent_id'			=>	  12,
					'meta_description'	=>    $faker->text(),
					'meta_keyword'		=>    $faker->text(),
				]
			);
		}
	}
}
