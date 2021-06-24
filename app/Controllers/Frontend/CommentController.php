<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Models\Comment;
use App\Models\Reply;
use App\Models\Post;

class CommentController extends BaseController
{
	protected $comment;
	protected $reply;
	protected $post;

	public function __construct()
	{
		$this->comment = new Comment();
		$this->reply = new Reply();
		$this->post = new Post();
	}

	public function postComment()
	{
		$input = $this->request->getPost([
			'body',
			'post_id',
		]);

		$input['user_id'] = user_id();

		if (!empty($input['body'])) {
			$message = '<p class="text-primary text-capitalize">Bình luận của bạn đã được đăng thành công!.</p>';
			$status = array(
				'error'  => 0,
				'message' => $message,
			);
			if ($this->request->getPost('comment_id') == 0) {
				$this->comment->insert($input);
			} else {
				$input['comment_id'] = $this->request->getPost('comment_id');
				$this->reply->insert($input);
			}
		} else {
			$message = '<p class="text-danger text-capitalize">Lỗi: Bình luận của bạn chưa được đăng.</p>';
			$status = array(
				'error'  => 1,
				'message' => $message,
			);
		}

		return json_encode($status);
	}

	public function showComments()
	{
		if ($this->request->isAjax()) {
			$html = '';
			$input = $this->request->getPost();
			$getListComment = $this->comment->getCommentByPost($input['post_id']);
			if (count($getListComment) > 0) {
				foreach ($getListComment as $item) {
					$html .= '<div class="media mb-2">';
					$html .= '<div class="avatar mr-75">';
					$html .= img(userShowImage($item['avatar'], $item['provider_name'], $item['provider_uid']), false, ['width' => 40, 'height' => 40, 'alt' => esc($item['fullname'])]);
					$html .= '</div>';
					$html .= '<div class="media-body">';
					$html .= '<h6 class="font-weight-bolder mb-25 text-capitalize">' . esc($item['fullname']) . '</h6>';
					$html .= '<p class="card-text">' . getDateHumanize(esc($item['created_at'])) . '</p>';
					$html .= '<p class="card-text">';
					$html .= esc($item['body']);
					$html .= '</p>';
					$html .= '<a href="javascript:void(0);" class="reply" id="' . esc($item['id']) . '" data-body="' . esc($item['body']) . '">';
					$html .= '<div class="d-inline-flex align-items-center">';
					$html .= '<i data-feather="corner-up-left" class="font-medium-3 mr-50"></i>';
					$html .= '<span>Reply</span>';
					$html .= '</div>';
					$html .= '</a>';
					$html .= $this->showReply($input['post_id'], $item['id']);
					$html .= '</div>';
					$html .= '</div>';
				}
			} else {
				$html .= '<div class="text-center"><p class="text-danger text-capitalize mb-0">Hiện tại chưa có bình lụân nào cho bài đăng này.</p></div>';
			}

			$data['html'] = $html;
			return json_encode($data);
		}
	}

	public function showReply($post_id, $id)
	{
		if ($this->request->isAjax()) {
			$html = '';
			$getListCommentReply = $this->reply->getReplyByComment($post_id, $id);
			if (count($getListCommentReply) > 0) {
				foreach ($getListCommentReply as $item) {
					$html .= '<div class="media mt-1">';
					$html .= '<div class="avatar mr-75">';
					$html .= img(userShowImage($item['avatar'], $item['provider_name'], $item['provider_uid']), false, ['width' => 40, 'height' => 40, 'alt' => esc($item['fullname'])]);
					$html .= '</div>';
					$html .= '<div class="media-body">';
					$html .= '<h6 class="font-weight-bolder mb-25 text-capitalize">' . esc($item['fullname']) . '</h6>';
					$html .= '<p class="card-text">' . getDateHumanize(esc($item['created_at'])) . '</p>';
					$html .= '<p class="card-text">';
					$html .= esc($item['body']);
					$html .= '</p>';
					$html .= '<a href="javascript:void(0);" class="reply" id="' . esc($item['id']) . '" data-body="' . esc($item['body']) . '">';
					$html .= '<div class="d-inline-flex align-items-center">';
					$html .= '<i data-feather="corner-up-left" class="font-medium-3 mr-50"></i>';
					$html .= '<span>Reply</span>';
					$html .= '</div>';
					$html .= '</a>';
					$html .= '</div>';
					$html .= '</div>';
				}
			}

			$data['html'] = $html;
			return $html;
		}
	}
}
