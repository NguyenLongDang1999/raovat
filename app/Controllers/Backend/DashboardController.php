<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;

class DashboardController extends BaseController
{
	public function index()
	{
		return view('backend/dashboard/index');
	}
}
