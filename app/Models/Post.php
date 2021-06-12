<?php

namespace App\Models;

use CodeIgniter\Model;

class Post extends Model
{
	protected $table                = 'post';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;

	protected $allowedFields = [
        'name',
        'slug',
        'cat_id',
        'is_type',
        'province_id',
        'district_id',
        'user_id',
        'price',
        'contact_address',
        'featured',
        'thumb_list',
        'description',
        'video',
        'video_description',
        'view',
        'expire_from',
        'expire_to',
        'status',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;
}
