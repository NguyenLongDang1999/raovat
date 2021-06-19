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

		$data['iTotalRecords'] = $data['iTotalDisplayRecords'] = count($results['model']);

		$data['aaData'] = array();
		if (count($results['model']) > 0) {
			foreach ($results['model'] as $row) {
				$price = ($row['price'] == 0) ? 'Thương Lượng' : $row['price'] . ' VNĐ';
				$img = explode(',', $row['thumb_list']);
				$diffDate = diffDate($row['expire_from'], $row['expire_to']);

				$data['aaData'][] = [
					'checkbox' => '',
					'responsive_id' => '',
					'responsive_id' => esc($row['id']),
					'image' => img(PATH_POST_SMALL_IMAGE . $img[0], false, ['class' => 'img-fluid', 'alt' => esc($row['name']), 'width' => 150, 'height' => 150]),
					'infoPost' => $this->infoPost($row['name'], $row['catName'], $row['provinceName'], $price),
					'infoDate' => $this->infoDate($diffDate, $row['expire_from'], $row['expire_to']),
					'featured' => esc($row['featured']),
					'status' => esc($row['status']),
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

		$data['iTotalRecords'] = $data['iTotalDisplayRecords'] = count($results['model']);

		$data['aaData'] = array();
		if (count($results['model']) > 0) {
			foreach ($results['model'] as $row) {
				$price = ($row['price'] == 0) ? 'Thương Lượng' : $row['price'] . ' VNĐ';
				$img = explode(',', $row['thumb_list']);
				$diffDate = diffDate($row['expire_from'], $row['expire_to']);

				$data['aaData'][] = [
					'responsive_id' => '',
					'responsive_id' => esc($row['id']),
					'image' => img(PATH_POST_SMALL_IMAGE . $img[0], false, ['class' => 'img-fluid', 'alt' => esc($row['name']), 'width' => 150, 'height' => 150]),
					'infoPost' => $this->infoPost($row['name'], $row['catName'], $row['provinceName'], $price),
					'infoDate' => $this->infoDate($diffDate, $row['expire_from'], $row['expire_to']),
					'featured' => esc($row['featured']),
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

		$data['iTotalRecords'] = $data['iTotalDisplayRecords'] = count($results['model']);

		$data['aaData'] = array();
		if (count($results['model']) > 0) {
			foreach ($results['model'] as $row) {
				$price = ($row['price'] == 0) ? 'Thương Lượng' : $row['price'] . ' VNĐ';
				$img = explode(',', $row['thumb_list']);
				$diffDate = diffDate($row['expire_from'], $row['expire_to']);

				$data['aaData'][] = [
					'checkbox' => '',
					'responsive_id' => '',
					'responsive_id' => esc($row['id']),
					'image' => img(PATH_POST_SMALL_IMAGE . $img[0], false, ['class' => 'img-fluid', 'alt' => esc($row['name']), 'width' => 150, 'height' => 150]),
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
		$html .= '<li class="pb-25">Ngày Bắt Đầu: <span class="text-bold-500">' . esc($expire_from) . '</span></li>';
		$html .= '<li class="pb-25">Ngày Hết Hạn: <span class="text-bold-500">' . esc($expire_to) . '</span></li>';
		$html .= '</ul>';
		return $html;
	}
}
