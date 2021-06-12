<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Banner;

class BannerController extends BaseController
{
	protected $banner;
	protected $category;

	public function __construct()
	{
		$this->banner = new Banner();
		$this->category = new Category();
	}

	public function index()
	{
		$option = $this->category->getTreeCategory();
		unset($option[0]);
		$option[0] = 'Banner Trang Chủ';
		$data['option'] = $option;
		return view('backend/banner/index', $data);
	}

	public function recycle()
	{
		return view('backend/banner/recycle');
	}

	public function create()
	{
		$option = $this->category->getTreeCategory();
		unset($option[0]);
		$option[0] = 'Banner Trang Chủ';
		$data['option'] = $option;
		return view('backend/banner/create_edit', $data);
	}

	public function edit($id)
	{
		$data['row'] = $this->banner->getDetailBanner($id);
		$option = $this->category->getTreeCategory();
		unset($option[0]);
		$option[0] = 'Banner Trang Chủ';
		$data['option'] = $option;
		return view('backend/banner/create_edit', $data);
	}

	public function getList()
	{
		helper('text');

		$input = $this->request->getGet();
		$data = array();

		$results = $this->banner->getList($input);

		$data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

		$data['aaData'] = array();
		if (count($results['model']) > 0) {
			foreach ($results['model'] as $row) {
				$orders = '';
				if ($row['orders'] == BANNER_TOP) {
					$orders .= 'Banner Trên';
				} else if ($row['orders'] == BANNER_MIDDLE) {
					$orders .= 'Banner Giữa';
				} else if ($row['orders'] == BANNER_BOTTOM) {
					$orders .= 'Banner Cuối';
				} else {
					$orders .= '';
				}

				$data['aaData'][] = [
					'checkbox' => '',
					'responsive_id' => '',
					'responsive_id' => esc($row['id']),
					'image' => img(PATH_BANNER_IMAGE . esc($row['image']), false, ['class' => 'rounded', 'width' => 150, 'height' => 150, 'alt' => esc($row['name'])]),
					'name' => character_limiter(esc($row['name']), 15, '...'),
					'orders' => $orders,
					'status' => esc($row['status']),
					'created_at' => esc($row['created_at']),
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

		$results = $this->banner->getListRecycle($input);

		$data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

		$data['aaData'] = array();
		if (count($results['model']) > 0) {
			foreach ($results['model'] as $row) {
				$orders = '';
				if ($row['orders'] == BANNER_TOP) {
					$orders .= 'Banner Trên';
				} else if ($row['orders'] == BANNER_MIDDLE) {
					$orders .= 'Banner Giữa';
				} else if ($row['orders'] == BANNER_BOTTOM) {
					$orders .= 'Banner Cuối';
				} else {
					$orders .= '';
				}

				$data['aaData'][] = [
					'checkbox' => '',
					'responsive_id' => '',
					'responsive_id' => esc($row['id']),
					'image' => img(PATH_BANNER_IMAGE . esc($row['image']), false, ['class' => 'rounded', 'width' => 150, 'height' => 150, 'alt' => esc($row['name'])]),
					'name' => character_limiter(esc($row['name']), 15, '...'),
					'orders' => $orders,
					'created_at' => esc($row['created_at']),
					'updated_at' => esc($row['updated_at']),
				];
			}
		}

		return json_encode($data);
	}

	public function store()
	{
		$input = $this->request->getPost([
			'name',
			'url',
			'description',
			'cat_id',
			'orders'
		]);

		// Upload File
		$file = $this->request->getFile('image');
		if ($file) {
			if ($file->isValid() && !$file->hasMoved()) {
				$fileName = $file->getRandomName();
				$file->move(PATH_BANNER_IMAGE, $fileName);

				$parts = explode('.', $fileName);
				$parts[count($parts) - 1] = 'webp';
				$fileNameNew = implode('.', $parts);
				if ($input['orders'] == BANNER_TOP) {
					$data = [
						'resizeX' => '728',
						'resizeY' => '300',
						'ratio' => false,
						'masterDim' => 'auto'
					];
				} else if ($input['orders'] == BANNER_MIDDLE || $input['orders'] == BANNER_BOTTOM) {
					$data = [
						'resizeX' => '200',
						'resizeY' => '200',
						'ratio' => false,
						'masterDim' => 'auto'
					];
				} else {
					// No thing
				}

				imageManipulation(PATH_BANNER_IMAGE, $fileName, $fileNameNew, '', $data);
				deleteImage(PATH_BANNER_IMAGE, $fileName);
				$input['image'] = $fileNameNew;
			}
		}

		$this->banner->insert($input);
		return redirect()->route('admin.banner.index')->with('success', "Banner <strong class='text-capitalize'>" . esc($input['name']) . "</strong> đã được thêm.");
	}

	public function update($id)
	{
		$input = $this->request->getPost([
			'name',
			'url',
			'description',
			'cat_id',
			'orders',
			'checkImg'
		]);

		// Upload File
		$file = $this->request->getFile('image');
		if ($file) {
			if ($file->isValid() && !$file->hasMoved()) {
				$fileName = $file->getRandomName();
				$file->move(PATH_BANNER_IMAGE, $fileName);

				$parts = explode('.', $fileName);
				$parts[count($parts) - 1] = 'webp';
				$fileNameNew = implode('.', $parts);
				if ($input['orders'] == BANNER_TOP) {
					$data = [
						'resizeX' => '728',
						'resizeY' => '300',
						'ratio' => false,
						'masterDim' => 'auto'
					];
				} else if ($input['orders'] == BANNER_MIDDLE || $input['orders'] == BANNER_BOTTOM) {
					$data = [
						'resizeX' => '200',
						'resizeY' => '200',
						'ratio' => false,
						'masterDim' => 'auto'
					];
				} else {
					// No thing
				}

				imageManipulation(PATH_BANNER_IMAGE, $fileName, $fileNameNew, '', $data);
				deleteImage(PATH_BANNER_IMAGE, $input['checkImg']);
				deleteImage(PATH_BANNER_IMAGE, $fileName);
				$input['image'] = $fileNameNew;
			}
		}

		$this->banner->update($id, $input);
		return redirect()->route('admin.banner.index')->with('success', "Banner <strong class='text-capitalize'>" . esc($input['name']) . "</strong> đã được cập nhật.");
	}

	public function multiStatus()
	{
		$input = $this->request->getPost('data');
		$status = $this->request->getPost('status');
		parse_str($input, $result);

		if (isset($result['chk']) && is_array($result['chk']) && $status !== null) {
			if ($this->banner->update($result['chk'], ['status' => $status])) {
				$data['result'] = true;
				$data['message'] = '<span class="text-capitalize">Cập nhật trạng thái thành công tất cả dữ liệu được chọn.</span>';
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
			if ($this->banner->delete($result['chk'])) {
				$data['result'] = true;
				$data['message'] = '<span class="text-capitalize">Xóa thành công tất cả dữ liệu được chọn.</span>';
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
			$multiBanner = $this->banner->getMultiImageBanner($result['chk']);
			deleteMultipleImage(PATH_BANNER_IMAGE, $multiBanner);
			if ($this->banner->delete($result['chk'], true)) {
				$data['result'] = true;
				$data['message'] = '<span class="text-capitalize">Xóa vĩnh viễn thành công tất cả dữ liệu được chọn.</span>';
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
			if ($this->banner->update($result['chk'], ['deleted_at' => NULL])) {
				$data['result'] = true;
				$data['message'] = '<span class="text-capitalize">Cập nhật trạng thái thành công tất cả dữ liệu được chọn.</span>';
				return json_encode($data);
			}
		}

		$data['result'] = false;
		return json_encode($data);
	}

	public function checkExists()
	{
		$url = $this->request->getPost('url');
		$result = $this->banner->checkExists($url);

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
