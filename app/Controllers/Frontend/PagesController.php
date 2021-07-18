<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\Pages;

class PagesController extends BaseController
{
	protected $pages;

	public function __construct()
	{
		$this->pages = new Pages();
	}

	public function index($url)
	{
		$data['row'] = $this->pages->getDetailByUrl($url);
		return view('frontend/pages/index', $data);
	}
}
