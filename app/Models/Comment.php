<?php

namespace App\Models;

use CodeIgniter\Model;

class Comment extends Model
{
	protected $table                = 'comment';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;

	protected $allowedFields        = [
		'body', 'user_id', 'post_id', 'status', 'deleted_at'
	];

	// Dates
	protected $useTimestamps        = true;
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';

	public function getCommentByPost($post_id)
	{
		return $this->select('comment.body, comment.id, comment.created_at,
			users.avatar, users.fullname')
			->join('users', 'users.id = comment.user_id')
			->where('comment.status', STATUS_ACTIVE)
			->where('comment.post_id', $post_id)
			->orderBy('comment.created_at', 'desc')
			->findAll();
	}
}
