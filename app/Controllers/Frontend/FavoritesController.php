<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\UserFavorites;
use App\Models\Post;

class FavoritesController extends BaseController
{
	protected $favorites;
	protected $post;

	public function __construct()
	{
		$this->favorites = new UserFavorites();
		$this->post = new Post();
	}

	public function index()
	{
		if ($this->request->isAjax()) {
			$post_id = $this->request->getPost('post_id');

			$checkFavoritesExists = $this->favorites->checkFavoritesExists($post_id, user_id());
			$getListPostByUser = $this->post->getListPostByUser(user_id());

			if (isset($post_id) && $post_id !== null && $checkFavoritesExists == 0) {
				if (count($getListPostByUser) > 0) {
					foreach ($getListPostByUser as $item) {
						if ($post_id == $item['id']) {
							$data['result'] = false;
							$data['message'] = '<span class="text-capitalize">Không thể lưu bài đăng của chính mình.</span>';
							return json_encode($data);
						}
					}
				}

				$data = [
					'post_id' => $post_id,
					'user_id' => user_id(),
				];

				if ($this->favorites->insert($data)) {
					$data['result'] = true;
					$data['message'] = '<span class="text-capitalize">Bài Đăng Đã Được Lưu Lại.</span>';
					return json_encode($data);
				}
			}

			$data['result'] = false;
			$data['message'] = '<span class="text-capitalize">Bài đăng này có thể bạn đã lưu rồi.</span>';
			return json_encode($data);
		}
	}

	public function removeFavorites()
	{
		$input = $this->request->getPost('data');
		parse_str($input, $result);

		if (isset($result['chk']) && is_array($result['chk'])) {
			if ($this->favorites->delete($result['chk'], true)) {
				$data['result'] = true;
				$data['message'] = '<span class="text-capitalize">Xóa vĩnh viễn thành công tất cả dữ liệu được chọn.</span>';
				return json_encode($data);
			}
		}

		$data['result'] = false;
		return json_encode($data);
	}

	public function showFavorites()
	{
		if ($this->request->isAjax()) {
			$data['getListFavorites'] = $this->post->getListFavorites(user_id());
			$data['getListFavoritesCount'] = $this->post->getListFavorites(user_id(), true);
			return view('templates/frontend/favorites_ajax', $data);
		}
	}
}
