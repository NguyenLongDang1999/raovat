<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;

class UserController extends BaseController
{
	public function index()
	{
		return view('frontend/user/index');
	}

	public function myProfile()
	{
		return view('frontend/user/my_profile');
	}
}
