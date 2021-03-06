<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Post;
use App\Models\Province;

class CategoryController extends BaseController
{
	protected $category;
	protected $post;
	protected $province;

	public function __construct()
	{
		$this->category = new Category();
		$this->post = new Post();
		$this->province = new Province();
	}

	public function index()
	{
		$data['getCategoryList'] = $this->category->getCategoryList();
		return view('frontend/category/index', $data);
	}

	public function newPost()
	{
		$input = $this->request->getGet();
		$data['getPostNews'] = $this->post->getPostNews(false, $input);
		$data['countPost'] = $this->post->getPostNews(true, $input);
		$data['pager'] = $this->post->pager;
		$data['input'] = $input;
		$data['province'] = $this->province->getProvince();
		$data['is_category_page'] = true;
		return view('frontend/category/new_post', $data);
	}

	public function postFeatured()
	{
		$input = $this->request->getGet();
		$data['getPostFeatured'] = $this->post->getPostFeatured(false, $input);
		$data['countPost'] = $this->post->getPostFeatured(true, $input);
		$data['pager'] = $this->post->pager;
		$data['input'] = $input;
		$data['province'] = $this->province->getProvince();
		$data['is_category_page'] = true;
		return view('frontend/category/post_featured', $data);
	}

	public function category($slug, $id)
	{
		$row = $this->category->getShowCategory($slug, $id);
		$listCatId = $this->category->getCategoryRecursive($row['id']);
		$getCategoryList = $this->category->getCategoryList($row['id']);

		if (count($getCategoryList) > 0) {
			$data['getCategoryList'] = $getCategoryList;
		} else {
			$data['getCategoryList'] = $this->category->getCategoryList($row['parent_id']);
		}
		// Filter
		$input = $this->request->getGet();
		$data['getPostShowByCat'] = $this->post->getPostShowByCat($listCatId, false, $input);
		$data['countPost'] = $this->post->getPostShowByCat($listCatId, true, $input);
		$data['pager'] = $this->post->pager;
		$data['row'] = $row;
		$data['breadcrumbs'] = $this->category->show_breadcumb($row['id']);
		$data['province'] = $this->province->getProvince();
		$data['input'] = $input;
		$data['is_category_page'] = true;
		return view('frontend/category/category', $data);
	}
}
