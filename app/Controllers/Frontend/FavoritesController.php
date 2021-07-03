<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\UserFavorites;

class FavoritesController extends BaseController
{
	protected $favorites;

	public function __construct()
	{
		$this->favorites = new UserFavorites();
	}

	public function index()
	{
		if ($this->request->isAjax()) {
			$post_id = $this->request->getPost('post_id');

			$checkFavoritesExists = $this->favorites->checkFavoritesExists($post_id, user_id());

			if (isset($post_id) && $post_id !== null && $checkFavoritesExists == 0) {

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
}
