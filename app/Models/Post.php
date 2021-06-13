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

    public function getPostShowByCat($listCatid, $count = false, $input = array())
    {
        $str = "";
        foreach ($listCatid as $item) {
            $str .= " cat_id = $item OR";
        }
        $str = rtrim($str, 'OR ');
        $query = $this->select('post.thumb_list, post.slug, post.name, post.price, 
        users.fullname, users.avatar, province.name as provinceName, post.created_at, 
        post.featured, category.slug as catSlug, post.view, post.id, district.name as districtName')
            ->join('category', 'category.id = post.cat_id')
            ->join('users', 'users.id = post.user_id')
            ->join('province', 'province.id = post.province_id')
            ->join('district', 'district.id = post.district_id')
            ->where('category.status', STATUS_ACTIVE)
            ->where('post.status', STATUS_POST_ACTIVE)
            ->groupStart()
            ->where($str)
            ->groupEnd();

        if (isset($input['price_range']) && $input['price_range'] != '') {
            if ($input['price_range'] == 1) {
                $query = $query->where('post.price <=', number_format(1000000, 0, '', ','));
            }

            if ($input['price_range'] == 2) {
                $query = $query->where('post.price >=', number_format(1000000, 0, '', ','));
                $query = $query->where('post.price <=', number_format(100000000, 0, '', ','));
            }
            
            if ($input['price_range'] == 3) {
                $query = $query->where('post.price >=', number_format(100000000, 0, '', ','));
                $query = $query->where('post.price <=', number_format(1000000000, 0, '', ','));
            }

            if ($input['price_range'] == 4) {
                $query = $query->where('post.price >=', number_format(1000000000, 0, '', ','));
            }
        }

        if (isset($input['is_type_filter']) && $input['is_type_filter'] != '') {
            $query = $query->where('post.is_type', $input['is_type_filter']);
        }

        if ($count) {
            $query = $query->countAllResults();
        } else {
            if (isset($input['paginate']) && $input['paginate'] != '') {
                $query = $query->paginate($input['paginate']);
            } else {
                $query = $query->paginate(18);
            }
        }

        return $query;
    }
}
