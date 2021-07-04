<?php

namespace App\Models;

use CodeIgniter\Model;

class Reply extends Model
{
	protected $table                = 'reply';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;

	protected $allowedFields        = [
		'body', 'user_id', 'post_id', 'comment_id', 'status', 'deleted_at'
	];

	// Dates
	protected $useTimestamps        = true;
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	public function getReplyByComment($post_id, $comment_id)
	{
		return $this->select('reply.body, reply.id, reply.created_at,
		users.avatar, users.fullname')
			->join('users', 'users.id = reply.user_id')
			->join('comment', 'comment.id = reply.comment_id')
			->where('comment.status', STATUS_ACTIVE)
			->where('reply.status', STATUS_ACTIVE)
			->where('reply.comment_id', $comment_id)
			->where('comment.post_id', $post_id)
			->orderBy('reply.created_at', 'desc')
			->findAll();
	}
}
