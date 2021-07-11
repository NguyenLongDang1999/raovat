<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use Myth\Auth\Models\UserModel;
use App\Models\Group;

class AdminController extends BaseController
{
	protected $user;
	protected $group;

	public function __construct()
	{
		$this->user = new UserModel();
		$this->group = new Group();
	}

	public function index()
	{
		return view('backend/admin/index');
	}

	public function getList()
	{
		helper('text');

		$input = $this->request->getGet();
		$data = array();

		$results = $this->user->getList($input);

		$data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

		$data['aaData'] = array();
		if (count($results['model']) > 0) {
			foreach ($results['model'] as $row) {
				$data['aaData'][] = [
					'checkbox' => '',
					'responsive_id' => '',
					'responsive_id' => esc($row['id']),
					'image' => '',
					'infoUser' => $this->infoUser($row['fullname'], $row['email'], $row['phone'], $row['gender']),
					'role' => '',
					'status' => esc($row['status']),
					'created_at' => esc($row['created_at']),
				];
			}
		}

		return json_encode($data);
	}

	private function infoUser($fullName, $email, $phone, $gender)
	{
		helper('text');
		$html = '';
		$html .= '<ul class="list-unstyled">';
		$html .= '<li class="pb-25">Họ Và Tên: <span class="text-bold-500">' . esc(character_limiter($fullName, 15, '...')) . '</span></li>';
		$html .= '<li class="pb-25">E-mail: <span class="text-bold-500">' . esc(character_limiter($email, 15, '...')) . '</span></li>';
		$html .= '<li class="pb-25">Số Điện Thoại: <span class="text-bold-500">' . esc($phone) . '</span></li>';
		$html .= '<li class="pb-25">Giới Tính: <span class="text-bold-500">' . esc(character_limiter($gender, 10, '...')) . '</span></li>';
		$html .= '</ul>';
		return $html;
	}
}
