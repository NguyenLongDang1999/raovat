<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Libraries\Slug;
use App\Models\Pages;

class PagesController extends BaseController
{
	protected $slug;
	protected $pages;

	public function __construct()
	{
		$this->slug = new Slug();
		$this->pages = new Pages();
	}

	public function index()
	{
		return view('backend/pages/index');
	}

	public function create()
	{
		return view('backend/pages/create_edit');
	}

	public function edit($id)
	{
		$data['row'] = $this->pages->getDetailPages($id);
		return view('backend/pages/create_edit', $data);
	}

	public function getList()
	{
		helper('text');

		$input = $this->request->getGet();
		$data = array();

		$results = $this->pages->getList($input);

		$data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

		$data['aaData'] = array();
		if (count($results['model']) > 0) {
			foreach ($results['model'] as $row) {
				$data['aaData'][] = [
					'checkbox' => '',
					'responsive_id' => '',
					'responsive_id' => esc($row['id']),
					'name' => character_limiter(esc($row['name']), 15, '...'),
					'url' => character_limiter(esc($row['url']), 15, '...'),
					'status' => esc($row['status']),
					'created_at' => esc(getDateTime($row['created_at'])),
				];
			}
		}

		return json_encode($data);
	}

	public function store()
	{
		$input = $this->request->getPost([
			'name',
			'description',
			'meta_keyword',
			'meta_description'
		]);

		$input['url'] = $this->slug->str_slug($input['name']);

		$this->pages->insert($input);
		return redirect()->route('admin.pages.index')->with('success', "Pages <strong class='text-capitalize'>" . esc($input['name']) . "</strong> đã được thêm.");
	}

	public function update($id)
	{
		$input = $this->request->getPost([
			'name',
			'description',
			'meta_keyword',
			'meta_description'
		]);

		$input['url'] = $this->slug->str_slug($input['name']);

		$this->pages->update($id, $input);
		return redirect()->route('admin.pages.index')->with('success', "Pages <strong class='text-capitalize'>" . esc($input['name']) . "</strong> đã được cập nhật.");
	}

	public function multiStatus()
	{
		$input = $this->request->getPost('data');
		$status = $this->request->getPost('status');
		parse_str($input, $result);

		if (isset($result['chk']) && is_array($result['chk']) && $status !== null) {
			if ($this->pages->update($result['chk'], ['status' => $status])) {
				$data['result'] = true;
				$data['message'] = '<span class="text-capitalize">Cập nhật trạng thái thành công tất cả dữ liệu được chọn.</span>';
				return json_encode($data);
			}
		}

		$data['result'] = false;
		return json_encode($data);
	}

	public function multiPurgeDestroy()
	{
		$input = $this->request->getPost('data');
		parse_str($input, $result);

		if (isset($result['chk']) && is_array($result['chk'])) {
			if ($this->pages->delete($result['chk'], true)) {
				$data['result'] = true;
				$data['message'] = '<span class="text-capitalize">Xóa vĩnh viễn thành công tất cả dữ liệu được chọn.</span>';
				return json_encode($data);
			}
		}

		$data['result'] = false;
		return json_encode($data);
	}
}
