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

	public function recycle()
	{
		return view('backend/category/recycle');
	}

	public function create()
	{
		$data['option'] = $this->category->getTreeCategory();
		return view('backend/category/create_edit', $data);
	}

	public function edit($id)
	{
		$data['row'] = $this->category->getDetailCategory($id);
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

				if ($row['parent_id'] == 0) {
					$showName = 'Là danh mục cha';
				} else {
					$showName = $this->category->getDetailCategory($row['parent_id'])['name'];
				}

				$data['aaData'][] = [
					'checkbox' => '',
					'responsive_id' => '',
					'responsive_id' => esc($row['id']),
					'name' => character_limiter(esc($row['name']), 15, '...'),
					'parent_id' => character_limiter(esc($showName), 15, '...'),
					'status' => esc($row['status']),
					'created_at' => esc($row['created_at']),
					'updated_at' => esc($row['updated_at'])
				];
			}
		}

		return json_encode($data);
	}

	public function getListRecycle()
	{
		helper('text');

		$input = $this->request->getGet();
		$data = array();

		$results = $this->category->getListRecycle($input);

		$data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

		$data['aaData'] = array();
		if (count($results['model']) > 0) {
			foreach ($results['model'] as $row) {

				if ($row['parent_id'] == 0) {
					$showName = 'Là danh mục cha';
				} else {
					$showName = $this->category->getDetailCategory($row['parent_id'], true)['name'];
				}

				$data['aaData'][] = [
					'checkbox' => '',
					'responsive_id' => '',
					'responsive_id' => esc($row['id']),
					'name' => character_limiter(esc($row['name']), 15, '...'),
					'parent_id' => character_limiter(esc($showName), 15, '...'),
					'created_at' => esc($row['created_at']),
					'updated_at' => esc($row['updated_at'])
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
			'parent_id',
			'meta_keyword',
			'meta_description'
		]);

		// Upload File
		$file = $this->request->getFile('image');
		if ($file) {
			if ($file->isValid() && !$file->hasMoved()) {
				$fileName = $file->getRandomName();
				$file->move(PATH_CATEGORY_IMAGE, $fileName);

				$parts = explode('.', $fileName);
				$parts[count($parts) - 1] = 'webp';
				$fileNameNew = implode('.', $parts);
				$data = [
					'resizeX' => '100',
					'resizeY' => '100',
					'ratio' => false,
					'masterDim' => 'auto'
				];
				imageManipulation(PATH_CATEGORY_IMAGE, $fileName, $fileNameNew, '', $data);
				deleteImage(PATH_CATEGORY_IMAGE, $fileName);
				$input['image'] = $fileNameNew;
			}
		}

		$input['slug'] = $this->slug->str_slug($input['name']);
		$this->category->insert($input);
		return redirect()->route('admin.category.index')->with('success', "Danh mục <strong class='text-capitalize'>" . esc($input['name']) . "</strong> đã được thêm.");
	}

	public function update($id)
	{
		$input = $this->request->getPost([
			'name',
			'description',
			'parent_id',
			'meta_keyword',
			'meta_description',
			'checkImg'
		]);

		// Upload File
		$file = $this->request->getFile('image');
		if ($file) {
			if ($file->isValid() && !$file->hasMoved()) {
				$fileName = $file->getRandomName();
				$file->move(PATH_CATEGORY_IMAGE, $fileName);

				$parts = explode('.', $fileName);
				$parts[count($parts) - 1] = 'webp';
				$fileNameNew = implode('.', $parts);
				$data = [
					'resizeX' => '100',
					'resizeY' => '100',
					'ratio' => false,
					'masterDim' => 'auto'
				];
				imageManipulation(PATH_CATEGORY_IMAGE, $fileName, $fileNameNew, '', $data);
				deleteImage(PATH_CATEGORY_IMAGE, $fileName);
				deleteImage(PATH_CATEGORY_IMAGE, $input['checkImg']);
				$input['image'] = $fileNameNew;
			}
		}

		$input['slug'] = $this->slug->str_slug($input['name']);
		$this->category->update($id, $input);
		return redirect()->route('admin.category.index')->with('success', "Danh mục <strong class='text-capitalize'>" . esc($input['name']) . "</strong> đã được cập nhật.");
	}

	public function multiStatus()
	{
		$input = $this->request->getPost('data');
		$status = $this->request->getPost('status');
		parse_str($input, $result);

		if (isset($result['chk']) && is_array($result['chk']) && $status !== null) {
			if ($this->category->checkParentCategory($result['chk']) == 0) {
				if ($this->category->update($result['chk'], ['status' => $status])) {
					$data['result'] = true;
					$data['message'] = '<span class="text-capitalize">Cập nhật trạng thái thành công tất cả dữ liệu được chọn.</span>';
					return json_encode($data);
				}
			} else {
				$data['result'] = false;
				$data['message'] = '<span class="text-capitalize">Danh mục có thể vẫn có danh mục con bên trong. Vui lòng kiểm tra lại.</span>';
				return json_encode($data);
			}
		}

		$data['result'] = false;
		return json_encode($data);
	}

	public function multiDestroy()
	{
		$input = $this->request->getPost('data');
		parse_str($input, $result);

		if (isset($result['chk']) && is_array($result['chk'])) {
			if ($this->category->checkParentCategory($result['chk']) == 0) {
				if ($this->category->delete($result['chk'])) {
					$data['result'] = true;
					$data['message'] = '<span class="text-capitalize">Xóa thành công tất cả dữ liệu được chọn.</span>';
					return json_encode($data);
				}
			} else {
				$data['result'] = false;
				$data['message'] = '<span class="text-capitalize">Danh mục có thể vẫn có danh mục con bên trong. Vui lòng kiểm tra lại.</span>';
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
			if ($this->category->checkParentCategory($result['chk'], true) == 0) {
				$multiCategory = $this->category->getMultiImageCategory($result['chk']);
				deleteMultipleImage($multiCategory);
				if ($this->category->delete($result['chk'], true)) {
					$data['result'] = true;
					$data['message'] = '<span class="text-capitalize">Xóa vĩnh viễn thành công tất cả dữ liệu được chọn.</span>';
					return json_encode($data);
				}
			} else {
				$data['result'] = false;
				$data['message'] = '<span class="text-capitalize">Danh mục có thể vẫn có danh mục con bên trong. Vui lòng kiểm tra lại.</span>';
				return json_encode($data);
			}
		}

		$data['result'] = false;
		return json_encode($data);
	}

	public function multiRestore()
	{
		$input = $this->request->getPost('data');
		parse_str($input, $result);

		if (isset($result['chk']) && is_array($result['chk'])) {
			if ($this->category->checkParentCategory($result['chk'], true) == 0) {
				if ($this->category->update($result['chk'], ['deleted_at' => NULL])) {
					$data['result'] = true;
					$data['message'] = '<span class="text-capitalize">Cập nhật trạng thái thành công tất cả dữ liệu được chọn.</span>';
					return json_encode($data);
				}
			} else {
				$data['result'] = false;
				$data['message'] = '<span class="text-capitalize">Danh mục có thể vẫn có danh mục con bên trong. Vui lòng kiểm tra lại.</span>';
				return json_encode($data);
			}
		}

		$data['result'] = false;
		return json_encode($data);
	}

	public function checkExists()
	{
		$name = $this->request->getPost('name');
		$slug = $this->slug->str_slug($name);
		$result = $this->category->checkExists($slug);

		$valid = true;
		if ($result > 0) {
			$valid = false;
		} else {
			$valid = true;
		}

		return $this->response->setJSON([
			'valid' => $valid,
		]);
	}
}
