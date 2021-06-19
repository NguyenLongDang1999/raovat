<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Post;

class HomeController extends BaseController
{
	protected $category;
	protected $post;
	
	public function __construct()
	{
		$this->category = new Category();
		$this->post = new Post();
	}

	public function index()
	{
		$data['getCategoryMenu'] = $this->category->getCategoryMenu();
		$data['getPostNew'] = $this->post->getPostHome();
		$data['getPostFeatured'] = $this->post->getPostHome(true);
		$data['is_home_page'] = true;
		return view('frontend/home/index', $data);
	}
}
