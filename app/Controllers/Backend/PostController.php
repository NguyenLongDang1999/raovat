<?php

namespace App\Controllers\Backend;

use App\Controllers\BaseController;
use App\Models\Category;
use App\Models\Post;
use App\Models\Province;

class PostController extends BaseController
{
	protected $post;
	protected $category;
	protected $province;

	public function __construct()
	{
		$this->post = new Post();
		$this->category = new Category();
		$this->province = new Province();
	}

	public function index()
	{
		$category = $this->category->getTreeCategory();
		unset($category[0]);
		$data['province'] = $this->province->getProvince();
		$data['option']  = $category;
		return view('backend/post/index', $data);
	}

	public function recycle()
	{
		$category = $this->category->getTreeCategory();
		unset($category[0]);
		$data['province'] = $this->province->getProvince();
		$data['option']  = $category;
		return view('backend/post/recycle', $data);
	}

	public function getList()
	{
		$input = $this->request->getGet();
		$data = array();

		$results = $this->post->getList($input);

		$data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

		$data['aaData'] = array();
		if (count($results['model']) > 0) {
			foreach ($results['model'] as $row) {
				$gender = ($row['gender'] == GENDER_MALE) ? 'Nam' : 'Nữ';
				$price = ($row['price'] != 0) ? esc(number_to_amount($row['price'], 2, 'vi_VN')) . ' VNĐ' : 'Thương Lượng';
				$diffDate = diffDate($row['expire_from'], $row['expire_to']);
				$img = explode(',', $row['thumb_list']);
				$path = postShowImage($img[0]);

				$data['aaData'][] = [
					'checkbox' => '',
					'responsive_id' => '',
					'responsive_id' => esc($row['id']),
					'image' => img($path, false, ['alt' => esc($row['name']), 'width' => 150, 'height' => 150]),
					'infoPost' => $this->infoPost($row['name'], $row['catName'], $row['provinceName'], $price),
					'infoDate' => $this->infoDate($diffDate, $row['expire_from'], $row['expire_to']),
					'infoUser' => $this->infoPostByUser($row['userName'], $row['email'], $gender),
					'status' => esc($row['status']),
					'featured' => esc($row['featured']),
					'detail' => route_to('admin.post.detail', $row['id'], $row['slug'])
				];
			}
		}

		return json_encode($data);
	}

	public function getListRecycle()
	{
		$input = $this->request->getGet();
		$data = array();

		$results = $this->post->getListRecycle($input);

		$data['iTotalRecords'] = $data['iTotalDisplayRecords'] = count($results['model']);

		$data['aaData'] = array();
		if (count($results['model']) > 0) {
			foreach ($results['model'] as $row) {
				$gender = ($row['gender'] == GENDER_MALE) ? 'Nam' : 'Nữ';
				$price = ($row['price'] != 0) ? esc(number_to_amount($row['price'], 2, 'vi_VN')) . ' VNĐ' : 'Thương Lượng';
				$diffDate = diffDate($row['expire_from'], $row['expire_to']);
				$img = explode(',', $row['thumb_list']);
				$path = '';
				if (!empty($img[0])) {
					$path .= PATH_POST_SMALL_IMAGE . $img[0];
				} else {
					$path .= PATH_POST_IMAGE_DEFAULT;
				}

				$data['aaData'][] = [
					'checkbox' => '',
					'responsive_id' => '',
					'responsive_id' => esc($row['id']),
					'image' => img($path, false, ['class' => 'img-fluid', 'alt' => esc($row['name']), 'width' => 150, 'height' => 150]),
					'infoPost' => $this->infoPost($row['name'], $row['catName'], $row['provinceName'], $price),
					'infoDate' => $this->infoDate($diffDate, $row['expire_from'], $row['expire_to']),
					'infoUser' => $this->infoPostByUser($row['userName'], $row['email'], $gender),
					'status' => esc($row['status']),
					'featured' => esc($row['featured']),
					'detail' => route_to('admin.post.detail', $row['id'], $row['slug'])
				];
			}
		}

		return json_encode($data);
	}

	public function multiDestroy()
	{
		$input = $this->request->getPost('data');
		parse_str($input, $result);

		if (isset($result['chk']) && is_array($result['chk'])) {
			if ($this->post->delete($result['chk'])) {
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
			$multiPost = $this->post->getMultiPost($result['chk']);

			foreach ($multiPost as $item) {
				$gallery = explode(',', $item['thumb_list']);
				deleteMultiplePostImage(PATH_POST_SMALL_IMAGE, $gallery);
				deleteMultiplePostImage(PATH_POST_MEDIUM_IMAGE, $gallery);
			}

			if ($this->post->delete($result['chk'], true)) {
				$data['result'] = true;
				$data['message'] = '<span class="text-capitalize">Xóa vĩnh viễn thành công tất cả dữ liệu được chọn.</span>';
				return json_encode($data);
			}
		}

		$data['result'] = false;
		return json_encode($data);
	}

	public function multiStatus()
	{
		$input = $this->request->getPost('data');
		$status = $this->request->getPost('status');
		parse_str($input, $result);

		if (isset($result['chk']) && is_array($result['chk']) && $status !== null) {
			if ($this->post->update($result['chk'], ['status' => $status])) {
				$data['result'] = true;
				$data['message'] = '<span class="text-capitalize">Cập nhật trạng thái thành công tất cả dữ liệu được chọn.</span>';
				return json_encode($data);
			}
		}

		$data['result'] = false;
		return json_encode($data);
	}

	public function multiFeatured()
	{
		$input = $this->request->getPost('data');
		$featured = $this->request->getPost('featured');
		parse_str($input, $result);

		if (isset($result['chk']) && is_array($result['chk']) && $featured !== null) {
			if ($this->post->update($result['chk'], ['featured' => $featured])) {
				$data['result'] = true;
				$data['message'] = '<span class="text-capitalize">Kích hoạt VIP tất cả dữ liệu được chọn.</span>';
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
			if ($this->post->update($result['chk'], ['deleted_at' => NULL])) {
				$data['result'] = true;
				$data['message'] = '<span class="text-capitalize">Cập nhật trạng thái thành công tất cả dữ liệu được chọn.</span>';
				return json_encode($data);
			}
		}

		$data['result'] = false;
		return json_encode($data);
	}

	public function detail($id)
	{
		$row = $this->post->getDetailPostBySlugBackend($id);
		if (is_null($row)) {
			return redirect()->back()->with('error', 'Bài đăng này đã xóa hoặc không tồn tại. Vui lòng kiểm tra lại.');
		}

		$data['gallery'] = explode(',', $row['thumb_list']);
		$data['breadcrumbs'] = $this->category->show_breadcumb($row['catId'], true);
		$data['row'] = $row;
		return view('backend/post/detail', $data);
	}

	public function showEdit($id)
	{
		$row = $this->post->getDetailPostBySlugBackend($id);
		if (is_null($row)) {
			return redirect()->back()->with('error', 'Bài đăng này đã xóa hoặc không tồn tại. Vui lòng kiểm tra lại.');
		}

		$data['gallery'] = explode(',', $row['thumb_list']);
		$data['breadcrumbs'] = $this->category->show_breadcumb($row['catId'], true);
		$data['row'] = $row;
		return view('backend/post/detail', $data);
	}

	private function infoPost($postName, $catName, $provinceName, $price)
	{
		helper('text');
		$html = '';
		$html .= '<ul class="list-unstyled">';
		$html .= '<li class="pb-25">Tiêu Đề: <span class="text-bold-500">' . esc(character_limiter($postName, 15, '...')) . '</span></li>';
		$html .= '<li class="pb-25">Danh Mục: <span class="text-bold-500">' . esc(character_limiter($catName, 15, '...')) . '</span></li>';
		$html .= '<li class="pb-25">Tỉnh/TP: <span class="text-bold-500">' . esc(character_limiter($provinceName, 10, '...')) . '</span></li>';
		$html .= '<li class="pb-25">Giá: <span class="text-bold-500">' . $price . '</span></li>';
		$html .= '</ul>';
		return $html;
	}

	private function infoDate($diff, $expire_from, $expire_to)
	{
		$html = '';
		$html .= '<ul class="list-unstyled">';
		$html .= '<li class="pb-25">Gói Đăng Tin: <span class="text-bold-500">' . esc($diff) . ' Ngày</span></li>';
		$html .= '<li class="pb-25">Ngày Bắt Đầu: <span class="text-bold-500">' . esc(getDateTime($expire_from)) . '</span></li>';
		$html .= '<li class="pb-25">Ngày Hết Hạn: <span class="text-bold-500">' . esc(getDateTime($expire_to) . ' 23:59:59') . '</span></li>';
		$html .= '</ul>';
		return $html;
	}

	private function infoPostByUser($userName, $email, $gender)
	{
		helper('text');
		$html = '';
		$html .= '<ul class="list-unstyled">';
		$html .= '<li class="pb-25">Họ Và Tên: <span class="text-bold-500">' . esc(character_limiter($userName, 15, '...')) . '</span></li>';
		$html .= '<li class="pb-25">E-mail: <span class="text-bold-500">' . esc(character_limiter($email, 15, '...')) . '</span></li>';
		$html .= '<li class="pb-25">Giới Tính: <span class="text-bold-500">' . esc(character_limiter($gender, 10, '...')) . '</span></li>';
		$html .= '</ul>';
		return $html;
	}
}
