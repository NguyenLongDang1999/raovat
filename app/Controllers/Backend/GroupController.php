<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\Group;

class GroupController extends BaseController
{
	protected $group;

	public function __construct()
	{
		$this->group = new Group();
	}

	public function index()
	{
		return view('backend/group/index');
	}

	public function getList()
	{
		helper('text');

		$input = $this->request->getGet();
		$data = array();

		$results = $this->group->getList($input);

		$data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

		$data['aaData'] = array();
		if (count($results['model']) > 0) {
			foreach ($results['model'] as $row) {
				$data['aaData'][] = [
					'checkbox' => '',
					'responsive_id' => '',
					'responsive_id' => esc($row['id']),
					'name' => character_limiter(esc($row['name']), 15, '...'),
					'description' => character_limiter(esc($row['description']), 15, '...'),
				];
			}
		}

		return json_encode($data);
	}

	public function create()
	{
		return view('backend/group/create_edit');
	}

	public function edit($id)
	{
		$data['row'] = $this->group->getDetailGroup($id);
		return view('backend/group/create_edit', $data);
	}

	public function store()
	{
		$input = $this->request->getPost([
			'name',
			'description',
		]);

		$this->group->insert($input);
		return redirect()->route('admin.group.index')->with('success', "Group User <strong class='text-capitalize'>" . esc($input['name']) . "</strong> đã được thêm.");
	}

	public function update($id)
	{
		$input = $this->request->getPost([
			'name',
			'description',
		]);

		$this->group->update($id, $input);
		return redirect()->route('admin.group.index')->with('success', "Group User <strong class='text-capitalize'>" . esc($input['name']) . "</strong> đã được cập nhật.");
	}

	public function multiPurgeDestroy()
	{
		$input = $this->request->getPost('data');
		parse_str($input, $result);

		if (isset($result['chk']) && is_array($result['chk'])) {
			if ($this->group->delete($result['chk'], true)) {
				$data['result'] = true;
				$data['message'] = '<span class="text-capitalize">Xóa vĩnh viễn thành công tất cả dữ liệu được chọn.</span>';
				return json_encode($data);
			}
		}

		$data['result'] = false;
		return json_encode($data);
	}
}
