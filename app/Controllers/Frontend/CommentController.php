<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends BaseController
{
	protected $comment;
	protected $post;

	public function __construct()
	{
		$this->comment = new Comment();
		$this->post = new Post();
	}

	public function postComment()
	{
		$input = $this->request->getPost([
			'body',
			'post_id',
			'comment_id',
		]);

		$input['parent_id'] = $input['comment_id'];
		if (!empty($input['body'])) {
			$message = '<label class="text-success">Bình luận của bạn đã được đăng thành công!.</label>';
			$status = array(
				'error'  => 0,
				'message' => $message,
				'csrf_hash' => csrf_hash()
			);
			$this->comment->insert($input);
		} else {
			$message = '<label class="text-danger">Lỗi: Bình luận của bạn chưa được đăng.</label>';
			$status = array(
				'error'  => 1,
				'message' => $message,
				'csrf_hash' => csrf_hash()
			);
		}

		return json_encode($status);
	}

	public function showComments()
	{
		if ($this->request->isAjax()) {
			$html = '';
			$input = $this->request->getPost();
			$getListComment = $this->comment->getCommentByPost($input['post_id'], 0);
			if (count($getListComment) > 0) {
				foreach ($getListComment as $item) {
					$html .= '<div class="media my-1">';
					if (isset($item['avatar'])) {
						$html .= img(PATH_USER_IMAGE_SMALL . $item['avatar'], false, ['alt' => esc($item['fullname']), 'width' => '40', 'height' => '40', 'class' => 'mr-1']);
					} else {
						$html .= img('app-assets/images/portrait/small/avatar-s.png', false, ['alt' => esc($item['fullname']), 'width' => '40', 'height' => '40', 'class' => 'mr-1']);
					}
					$html .= '<div class="media-body">';
					$html .= '<h5 class="mt-0 text-capitalize mb-0">' . esc($item['fullname']) . '</h5>';
					$html .= '<small class="text-muted"><i class="bx bx-time"></i>' . getDateHumanize($item['created_at']) . '</small>';
					$html .= '<a href="javascript:void(0);" class="reply" id="' . esc($item['id']) . '" data-body="' . esc($item['body']) . '">';
					$html .= '<i class="bx bx-reply ml-1"></i> Reply';
					$html .= '</a>';
					$html .= '<span class="d-block">';
					$html .= esc($item['body']);
					$html .= '</span>';
					$html .= $this->showReply($input['post_id'], $item['id']);
					$html .= '</div>';
					$html .= '</div>';
				}
			} else {
				$html .= '<p class="text-danger">Hiện tại chưa có bình lụân nào cho bài đăng này.</p>';
			}

			$data['csrf_hash'] = csrf_hash();
			$data['html'] = $html;
			return json_encode($data);
		}
	}

	public function showReply($post_id, $id)
	{
		if ($this->request->isAjax()) {
			$html = '';
			$getListCommentReply = $this->comment->getCommentByPost($post_id, $id);
			if (count($getListCommentReply) > 0) {
				foreach ($getListCommentReply as $reply) {
					$html .= '<div class="media mt-1">';
					if (isset($reply['avatar'])) {
						$html .= img(PATH_USER_IMAGE_SMALL . $reply['avatar'], false, ['alt' => esc($reply['fullname']), 'width' => '40', 'height' => '40', 'class' => 'mr-1']);
					} else {
						$html .= img('app-assets/images/portrait/small/avatar-s.png', false, ['alt' => esc($reply['fullname']), 'width' => '40', 'height' => '40', 'class' => 'mr-1']);
					}
					$html .= '<div class="media-body">';
					$html .= '<h5 class="mt-0 text-capitalize mb-0">' . esc($reply['fullname']) . '</h5>';
					$html .= '<small class="text-muted"><i class="bx bx-time"></i>' . getDateHumanize($reply['created_at']) . '</small>';
					$html .= '<a href="javascript:void(0);" class="reply" id="' . esc($reply['id']) . '" data-body="' . esc($reply['body']) . '">';
					$html .= '<i class="bx bx-reply ml-1"></i> Reply';
					$html .= '</a>';
					$html .= '<span class="d-block">';
					$html .= esc($reply['body']);
					$html .= '</span>';
					$html .= '</div>';
					$html .= '</div>';

					$html .= $this->showReply($post_id, $reply['id']);
				}
			}

			$data['csrf_hash'] = csrf_hash();
			$data['html'] = $html;
			return $html;
		}
	}
}
