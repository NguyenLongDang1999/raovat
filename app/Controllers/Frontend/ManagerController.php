<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Libraries\Slug;
use App\Models\Post;
use App\Models\Category;
use App\Models\Province;
use App\Models\District;

class ManagerController extends BaseController
{
	protected $slug;
	protected $post;
	protected $province;
	protected $district;
	protected $category;

	public function __construct()
	{
		$this->slug = new Slug();
		$this->category = new Category();
		$this->province = new Province();
		$this->district = new District();
		$this->post = new Post();
	}

	public function index()
	{
		return view('frontend/manager/index');
	}

	public function getPostList()
	{
		$input = $this->request->getGet();
		$input['user_id'] = user()->id;
		$data = array();

		$results = $this->post->getPostListManager($input);

		$data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

		$data['aaData'] = array();
		if (count($results['model']) > 0) {
			foreach ($results['model'] as $row) {
				$price = ($row['price'] != 0) ? esc(number_to_amount($row['price'], 2, 'vi_VN')) : 'Thương Lượng' . ' VNĐ';
				$diffDate = diffDate($row['expire_from'], $row['expire_to']);
				$img = explode(',', $row['thumb_list']);
				$path = postShowImage($img[0]);

				$data['aaData'][] = [
					'checkbox' => '',
					'responsive_id' => '',
					'responsive_id' => esc($row['id']),
					'image' => img($path, false, ['class' => 'img-fluid', 'alt' => esc($row['name']), 'width' => 150, 'height' => 150]),
					'infoPost' => $this->infoPost($row['name'], $row['catName'], $row['provinceName'], $price),
					'infoDate' => $this->infoDate($diffDate, $row['expire_from'], $row['expire_to']),
					'featured' => esc($row['featured']),
					'status' => esc($row['status']),
					'detail' => route_to('user.post.detail', esc($row['catSlug']), esc($row['slug']), esc($row['id']))
				];
			}
		}

		return json_encode($data);
	}

	public function getPostListBlock()
	{
		$input = $this->request->getGet();
		$input['user_id'] = user()->id;
		$data = array();

		$results = $this->post->getPostListManager($input);

		$data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

		$data['aaData'] = array();
		if (count($results['model']) > 0) {
			foreach ($results['model'] as $row) {
				$price = ($row['price'] != 0) ? esc(number_to_amount($row['price'], 2, 'vi_VN')) : 'Thương Lượng' . ' VNĐ';
				$diffDate = diffDate($row['expire_from'], $row['expire_to']);
				$img = explode(',', $row['thumb_list']);
				$path = postShowImage($img[0]);

				$data['aaData'][] = [
					'responsive_id' => '',
					'responsive_id' => esc($row['id']),
					'image' => img($path, false, ['class' => 'img-fluid', 'alt' => esc($row['name']), 'width' => 150, 'height' => 150]),
					'infoPost' => $this->infoPost($row['name'], $row['catName'], $row['provinceName'], $price),
					'infoDate' => $this->infoDate($diffDate, $row['expire_from'], $row['expire_to']),
					'featured' => esc($row['featured']),
					'detail' => route_to('user.post.detail', esc($row['catSlug']), esc($row['slug']), esc($row['id']))
				];
			}
		}

		return json_encode($data);
	}

	public function getPostListReady()
	{
		$input = $this->request->getGet();
		$input['user_id'] = user()->id;
		$data = array();

		$results = $this->post->getPostListManager($input);

		$data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

		$data['aaData'] = array();
		if (count($results['model']) > 0) {
			foreach ($results['model'] as $row) {
				$price = ($row['price'] != 0) ? esc(number_to_amount($row['price'], 2, 'vi_VN')) : 'Thương Lượng' . ' VNĐ';
				$diffDate = diffDate($row['expire_from'], $row['expire_to']);
				$img = explode(',', $row['thumb_list']);
				$path = postShowImage($img[0]);

				$data['aaData'][] = [
					'checkbox' => '',
					'responsive_id' => '',
					'responsive_id' => esc($row['id']),
					'image' => img($path, false, ['class' => 'img-fluid', 'alt' => esc($row['name']), 'width' => 150, 'height' => 150]),
					'infoPost' => $this->infoPost($row['name'], $row['catName'], $row['provinceName'], $price),
					'infoDate' => $this->infoDate($diffDate, $row['expire_from'], $row['expire_to']),
					'featured' => esc($row['featured']),'detail' => route_to('user.post.detail', esc($row['catSlug']), esc($row['slug']), esc($row['id']))
				];
			}
		}

		return json_encode($data);
	}
	
	public function getPostListSave()
	{
		$input = $this->request->getGet();
		$data = array();

		$results = $this->post->getListFavoritesManager($input, user_id());

		$data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

		$data['aaData'] = array();
		if (count($results['model']) > 0) {
			foreach ($results['model'] as $row) {
				$gender = ($row['gender'] == GENDER_MALE) ? 'Nam' : 'Nữ';
				$price = ($row['price'] != 0) ? esc(number_to_amount($row['price'], 2, 'vi_VN')) : 'Thương Lượng' . ' VNĐ';
				$diffDate = diffDate($row['expire_from'], $row['expire_to']);
				$img = explode(',', $row['thumb_list']);
				$path = postShowImage($img[0]);

				$data['aaData'][] = [
					'checkbox' => '',
					'responsive_id' => '',
					'responsive_id' => esc($row['favoritesId']),
					'image' => img($path, false, ['class' => 'img-fluid', 'alt' => esc($row['name']), 'width' => 150, 'height' => 150]),
					'infoPost' => $this->infoPost($row['name'], $row['catName'], $row['provinceName'], $price),
					'infoDate' => $this->infoDate($diffDate, $row['expire_from'], $row['expire_to']),
					'infoUser' => $this->infoPostByUser($row['userName'], $row['email'], $gender),
					'featured' => esc($row['featured']),
					'detail' => route_to('user.post.detail', esc($row['catSlug']), esc($row['slug']), esc($row['id']))
				];
			}
		}

		return json_encode($data);
	}

	public function getPostListExpire()
	{
		$input = $this->request->getGet();
		$input['user_id'] = user()->id;
		$data = array();

		$input['expire'] = true;
		$results = $this->post->getPostListManager($input);

		$data['iTotalRecords'] = $data['iTotalDisplayRecords'] = $results['total'];

		$data['aaData'] = array();
		if (count($results['model']) > 0) {
			foreach ($results['model'] as $row) {
				$price = ($row['price'] != 0) ? esc(number_to_amount($row['price'], 2, 'vi_VN')) : 'Thương Lượng' . ' VNĐ';
				$diffDate = diffDate($row['expire_from'], $row['expire_to']);
				$img = explode(',', $row['thumb_list']);
				$path = postShowImage($img[0]);

				$data['aaData'][] = [
					'responsive_id' => '',
					'responsive_id' => esc($row['id']),
					'image' => img($path, false, ['class' => 'img-fluid', 'alt' => esc($row['name']), 'width' => 150, 'height' => 150]),
					'infoPost' => $this->infoPost($row['name'], $row['catName'], $row['provinceName'], $price),
					'infoDate' => $this->infoDate($diffDate, $row['expire_from'], $row['expire_to']),
					'featured' => esc($row['featured']),
				];
			}
		}

		return json_encode($data);
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

	public function edit($id)
	{
		$row = $this->post->getDetailPostById($id, user()->id);
		if (!isset($row)) {
			return redirect()->route('user.user.manager')->with('error', "Tin đăng này không tồn tại! Vui lòng kiểm tra lại");
		}

		$data['row'] = $row;
		$data['province'] = $this->province->getProvince();
		$category = $this->category->getTreeCategory();
		unset($category[0]);
		$data['category'] = $category;
		return view('frontend/post/create_edit', $data);
	}

	public function update($id)
	{
		$input = $this->request->getPost([
			'name',
			'cat_id',
			'is_type',
			'province_id',
			'district_id',
			'contact_address',
			'description',
			'video',
			'video_description'
		]);

		$input['price'] = str_replace(',', '', $this->request->getPost('price'));
		$input['slug'] = $this->slug->str_slug($input['name']);

		$row = $this->post->getDetailPostById($id, user()->id);

		// Upload Multiple Files
		$files = $this->request->getFiles();
		$thumb_list = '';

		if ($files) {
			foreach ($files['photos'] as $file) {
				if ($file->isValid() && !$file->hasMoved()) {
					$fileName = $file->getRandomName();
					$file->move(PATH_POST_IMAGE, $fileName);

					$parts = explode('.', $fileName);
					$parts[count($parts) - 1] = 'webp';
					$fileNameNew = implode('.', $parts);
					$dataSmall = [
						'resizeX' => '350',
						'resizeY' => '250',
						'ratio' => false,
						'masterDim' => 'auto'
					];
					imageManipulation(PATH_POST_IMAGE, $fileName, $fileNameNew, 'small', $dataSmall);
					$dataMedium = [
						'resizeX' => '650',
						'resizeY' => '450',
						'ratio' => false,
						'masterDim' => 'auto'
					];
					imageManipulation(PATH_POST_IMAGE, $fileName, $fileNameNew, 'medium', $dataMedium);
					$thumb_list .= $fileNameNew . ',';

					$gallery = explode(',', $row['thumb_list']);
					deleteImage(PATH_POST_IMAGE, $fileName);
					deleteMultiplePostImage(PATH_POST_SMALL_IMAGE, $gallery);
					deleteMultiplePostImage(PATH_POST_MEDIUM_IMAGE, $gallery);
				} else {
					$thumb_list .= $row['thumb_list'];
				}
			}

			$thumb_list = rtrim($thumb_list, ',');
			$input['thumb_list'] = $thumb_list;
		}

		$this->post->update($id, $input);
		return redirect()->route('user.user.manager')->with('success', "Bài đăng <strong class='text-capitalize'>" . $input['name'] . "</strong> đã được cập nhật thành công.");
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
}
