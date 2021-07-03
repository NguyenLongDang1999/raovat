<?php

namespace App\Models;

use CodeIgniter\Model;

class UserFavorites extends Model
{
	protected $table                = 'users_favorites';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = true;

    protected $allowedFields        = [
        'user_id',
        'post_id',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps        = true;
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    public function checkFavoritesExists($post_id, $user_id)
    {
        return $this->select('id')
        ->where('post_id', $post_id)
        ->where('user_id', $user_id)
        ->countAllResults();
    }
}
