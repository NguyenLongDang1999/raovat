<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Libraries\Slug;
use App\Models\Category;

class CategoryController extends BaseController
{
	protected $slug;
	protected $category;

	public function __construct()
	{
		$this->slug = new Slug();
		$this->category = new Category();
	}

	public function index()
	{
		return view('backend/category/index');
	}

	public function create()
	{
		$data['option'] = $this->category->getTreeCategory();
		return view('backend/category/create_edit', $data);
	}

	public function getList()
	{
		helper('text');

		$input = $this->request->getGet();
		$data = array();

		$results = $this->category->getList($input);

		$data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

		$data['aaData'] = array();
		if (count($results['model']) > 0) {
			foreach ($results['model'] as $row) {
				$data['aaData'][] = [
					'checkbox' => '',
					'responsive_id' => '',
					'responsive_id' => esc($row['id']),
					'name' => character_limiter(esc($row['name']), 15, '...'),
					'parent_id' => character_limiter(esc($row['name']), 15, '...'),
					'status' => esc($row['status']),
					'created_at' => esc($row['created_at']),
					'updated_at' => esc($row['updated_at'])
				];
			}
		}

		return json_encode($data);
	}
}
