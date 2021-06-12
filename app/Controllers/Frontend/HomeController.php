<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;

class HomeController extends BaseController
{
	public function index()
	{
		return view('frontend/home/index');
	}
}
