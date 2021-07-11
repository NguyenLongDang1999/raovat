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
            ->where('post.expire_to >=', date('Y-m-d'))
            ->groupStart()
            ->where($str)
            ->groupEnd();

        if (isset($input['price_range']) && $input['price_range'] != '') {
            if ($input['price_range'] == 1) {
                $query = $query->where('post.price <=', 1000000);
            }

            if ($input['price_range'] == 2) {
                $query = $query->where('post.price >=', 1000000);
                $query = $query->where('post.price <=', 100000000);
            }

            if ($input['price_range'] == 3) {
                $query = $query->where('post.price >=', 100000000);
                $query = $query->where('post.price <=', 1000000000);
            }

            if ($input['price_range'] == 4) {
                $query = $query->where('post.price >=', 1000000000);
            }
        }

        if (isset($input['is_type_filter']) && $input['is_type_filter'] !== '') {
            $query = $query->where('post.is_type', $input['is_type_filter']);
        }

        if (isset($input['sort_filter']) && $input['sort_filter'] != '') {
            if ($input['sort_filter'] == 0) {
                $query = $query->orderBy('post.featured', 'desc');
                $query = $query->orderBy('post.created_at', 'desc');
            }

            if ($input['sort_filter'] == 1) {
                $query = $query->orderBy('post.created_at', 'asc');
            }

            if ($input['sort_filter'] == 2) {
                $query = $query->orderBy('post.view', 'asc');
            }

            if ($input['sort_filter'] == 3) {
                $query = $query->orderBy('post.view', 'desc');
            }

            if ($input['sort_filter'] == 4) {
                $query = $query->orderBy('post.price', 'asc');
            }

            if ($input['sort_filter'] == 5) {
                $query = $query->orderBy('post.price', 'desc');
            }

            if ($input['sort_filter'] == 6) {
                $query = $query->orderBy('post.name', 'asc');
            }

            if ($input['sort_filter'] == 7) {
                $query = $query->orderBy('post.name', 'desc');
            }
        } else {
            $query = $query->orderBy('post.featured', 'desc');
            $query = $query->orderBy('post.created_at', 'desc');
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

    public function getPostNews($count = false, $input = array())
    {
        $query = $this->select('post.thumb_list, post.slug, post.name, post.price, 
        users.fullname, users.avatar, province.name as provinceName, post.created_at, 
        post.featured, category.slug as catSlug, post.view, post.id, district.name as districtName')
            ->join('category', 'category.id = post.cat_id')
            ->join('users', 'users.id = post.user_id')
            ->join('province', 'province.id = post.province_id')
            ->join('district', 'district.id = post.district_id')
            ->where('category.status', STATUS_ACTIVE)
            ->where('post.status', STATUS_POST_ACTIVE)
            ->where('post.expire_to >=', date('Y-m-d'));

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

        if (isset($input['is_type_filter']) && $input['is_type_filter'] !== '') {
            $query = $query->where('post.is_type', $input['is_type_filter']);
        }

        if (isset($input['sort_filter']) && $input['sort_filter'] != '') {
            if ($input['sort_filter'] == 0) {
                $query = $query->orderBy('post.featured', 'desc');
                $query = $query->orderBy('post.created_at', 'desc');
            }

            if ($input['sort_filter'] == 1) {
                $query = $query->orderBy('post.created_at', 'asc');
            }

            if ($input['sort_filter'] == 2) {
                $query = $query->orderBy('post.view', 'asc');
            }

            if ($input['sort_filter'] == 3) {
                $query = $query->orderBy('post.view', 'desc');
            }

            if ($input['sort_filter'] == 4) {
                $query = $query->orderBy('post.price', 'asc');
            }

            if ($input['sort_filter'] == 5) {
                $query = $query->orderBy('post.price', 'desc');
            }

            if ($input['sort_filter'] == 6) {
                $query = $query->orderBy('post.name', 'asc');
            }

            if ($input['sort_filter'] == 7) {
                $query = $query->orderBy('post.name', 'desc');
            }
        } else {
            $query = $query->orderBy('post.featured', 'desc');
            $query = $query->orderBy('post.created_at', 'desc');
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

    public function getList($input = array())
    {
        $model = $this->select('post.id, post.name, post.cat_id, post.province_id, post.price,
            post.slug, post.status, post.featured, category.name as catName, province.name as provinceName,
            post.thumb_list, post.expire_from, post.expire_to, category.slug as catSlug, post.slug,
            users.gender, users.fullname as userName, users.email')
            ->join('category', 'category.id = post.cat_id')
            ->join('users', 'users.id = post.user_id')
            ->join('province', 'province.id = post.province_id');

        if (isset($input['search']['name']) && $input['search']['name'] != "") {
            $model->like('post.name', trim($input['search']['name']));
        }

        if (isset($input['search']['status']) && $input['search']['status'] != "") {
            $model->where('post.status', $input['search']['status']);
        }

        if (isset($input['search']['cat_id']) && $input['search']['cat_id'] != "") {
            $model->where('post.cat_id', $input['search']['cat_id']);
        }

        if (isset($input['search']['province_id']) && $input['search']['province_id'] != "") {
            $model->where('post.province_id', $input['search']['province_id']);
        }

        if (isset($input['search']['fullname']) && $input['search']['fullname'] != "") {
            $model->like('users.fullname', trim($input['search']['fullname']));
        }

        if (isset($input['search']['gender']) && $input['search']['gender'] != "") {
            $model->where('users.gender', $input['search']['gender']);
        }

        if (isset($input['search']['email']) && $input['search']['email'] != "") {
            $model->like('users.email', trim($input['search']['email']));
        }

        if (isset($input['search']['featured']) && $input['search']['featured'] != "") {
            $model->where('post.featured', $input['search']['featured']);
        }

        if (isset($input['iSortCol_0'])) {
            $sorting_mapping_array = array(
                '2' => 'post.name',
                '5' => 'post.created_at',
                '6' => 'post.updated_at',
            );

            $order = "desc";
            if (isset($input['sSortDir_0'])) {
                $order = $input['sSortDir_0'];
            }

            if (isset($sorting_mapping_array[$input['iSortCol_0']])) {
                $model->orderBy($sorting_mapping_array[$input['iSortCol_0']], $order);
            }
        }

        $result['model'] = $model->findAll($input['iDisplayStart'], $input['iDisplayLength']);

        return $result;
    }

    public function getListRecycle($input = array())
    {
        $model = $this->select('post.id, post.name, post.cat_id, post.province_id, post.price,
            post.slug, post.status, post.featured, category.name as catName, province.name as provinceName,
            post.thumb_list, post.expire_from, post.expire_to, category.slug as catSlug, post.slug,
            users.gender, users.fullname as userName, users.email')
            ->join('category', 'category.id = post.cat_id')
            ->join('users', 'users.id = post.user_id')
            ->join('province', 'province.id = post.province_id')
            ->onlyDeleted();

        if (isset($input['search']['name']) && $input['search']['name'] != "") {
            $model->like('post.name', trim($input['search']['name']));
        }

        if (isset($input['search']['status']) && $input['search']['status'] != "") {
            $model->where('post.status', $input['search']['status']);
        }

        if (isset($input['search']['cat_id']) && $input['search']['cat_id'] != "") {
            $model->where('post.cat_id', $input['search']['cat_id']);
        }

        if (isset($input['search']['province_id']) && $input['search']['province_id'] != "") {
            $model->where('post.province_id', $input['search']['province_id']);
        }

        if (isset($input['search']['fullname']) && $input['search']['fullname'] != "") {
            $model->like('users.fullname', trim($input['search']['fullname']));
        }

        if (isset($input['search']['gender']) && $input['search']['gender'] != "") {
            $model->where('users.gender', $input['search']['gender']);
        }

        if (isset($input['search']['email']) && $input['search']['email'] != "") {
            $model->like('users.email', trim($input['search']['email']));
        }

        if (isset($input['search']['featured']) && $input['search']['featured'] != "") {
            $model->where('post.featured', $input['search']['featured']);
        }

        if (isset($input['iSortCol_0'])) {
            $sorting_mapping_array = array(
                '2' => 'post.name',
                '5' => 'post.created_at',
                '6' => 'post.updated_at',
            );

            $order = "desc";
            if (isset($input['sSortDir_0'])) {
                $order = $input['sSortDir_0'];
            }

            if (isset($sorting_mapping_array[$input['iSortCol_0']])) {
                $model->orderBy($sorting_mapping_array[$input['iSortCol_0']], $order);
            }
        }

        $result['model'] = $model->findAll($input['iDisplayStart'], $input['iDisplayLength']);

        return $result;
    }

    public function getDetailPostBySlugBackend($id)
    {
        $model = $this->select('post.name, post.created_at, post.description, post.thumb_list,
            users.fullname, users.gender, users.email, users.phone, post.view, post.id as postId,
            post.contact_address, post.is_type, post.price, post.video, post.video_description, post.featured,
            users.avatar, post.status, category.id as catId, district.name as districtName, province.name as provinceName')
            ->join('category', 'category.id = post.cat_id')
            ->join('users', 'users.id = post.user_id')
            ->join('province', 'province.id = post.province_id')
            ->join('district', 'district.id = post.district_id')
            ->where('post.id', $id)
            ->orderBy('post.created_at', 'desc');

        return $model->first();
    }

    public function getMultiPost($id)
    {
        return $this->select('thumb_list')->whereIn('id', $id)->withDeleted()->findAll();
    }

    public function getDetailPostBySlug($catSlug, $postSlug, $id)
    {
        $model = $this->select('post.name, post.created_at, post.description, post.thumb_list,
            users.fullname, users.gender, users.email, users.phone, post.view, post.id as postId,
            post.contact_address, post.is_type, post.price, post.video, post.video_description, post.featured,
            users.avatar, post.status, category.id as catId, post.meta_description, post.meta_keyword,
            district.name as districtName, province.name as provinceName, post.cat_id')
            ->join('category', 'category.id = post.cat_id')
            ->join('users', 'users.id = post.user_id')
            ->join('province', 'province.id = post.province_id')
            ->join('district', 'district.id = post.district_id')
            ->where('post.expire_to >=', date('Y-m-d'))
            ->where('users.active', STATUS_ACTIVE)
            ->where('post.status', STATUS_POST_ACTIVE)
            ->where('category.slug', $catSlug)
            ->where('post.slug', $postSlug)
            ->where('post.id', $id)
            ->orderBy('post.created_at', 'desc');

        return $model->first();
    }

    public function getPostHome($featured = false)
    {
        $model = $this->select('post.thumb_list, post.slug, post.name, post.price, 
        users.fullname, users.avatar, province.name as provinceName, post.created_at, 
        post.featured, category.slug as catSlug, post.view, post.id, district.name as districtName')
            ->join('category', 'category.id = post.cat_id')
            ->join('users', 'users.id = post.user_id')
            ->join('province', 'province.id = post.province_id')
            ->join('district', 'district.id = post.district_id')
            ->where('category.status', STATUS_ACTIVE)
            ->where('post.status', STATUS_POST_ACTIVE)
            ->where('post.expire_to >=', date('Y-m-d'))
            ->orderBy('created_at', 'desc');

        if ($featured) {
            $model = $model->where('post.featured', FEATURED_ACTIVE);
            return $model->findAll(10);
        }

        return $model->findAll(15);
    }

    // User Manager
    public function getPostListManager($input = array())
    {
        $model = $this->select('post.id, post.name, post.cat_id, post.province_id, post.price,
            post.slug, post.status, post.featured, category.name as catName, province.name as provinceName,
            post.thumb_list, post.expire_from, post.expire_to, category.slug as catSlug, post.slug')
            ->join('category', 'category.id = post.cat_id')
            ->join('users', 'users.id = post.user_id')
            ->join('province', 'province.id = post.province_id');
        if (isset($input['expire']) && $input['expire']) {
            $model->where('post.expire_to <', date('Y-m-d'));
        } else {
            $model->where('post.expire_to >=', date('Y-m-d'));
        }
        $model->where('category.status', STATUS_ACTIVE)
            ->where('users.id', $input['user_id']);

        if (isset($input['search']['name']) && $input['search']['name'] != "") {
            $model->like('post.name', trim($input['search']['name']));
        }

        if (isset($input['search']['status']) && $input['search']['status'] != "") {
            if ($input['search']['status'] == STATUS_POST_ACTIVE) {
                $model->whereIn('post.status', [STATUS_POST_ACTIVE, STATUS_POST_HIDDEN]);
            } else {
                $model->where('post.status', $input['search']['status']);
            }
        }

        if (isset($input['iSortCol_0'])) {
            $sorting_mapping_array = array(
                '2' => 'post.name',
                '3' => 'post.created_at',
                '5' => 'post.created_at',
            );

            $order = "desc";
            if (isset($input['sSortDir_0'])) {
                $order = $input['sSortDir_0'];
            }

            if (isset($sorting_mapping_array[$input['iSortCol_0']])) {
                $model->orderBy($sorting_mapping_array[$input['iSortCol_0']], $order);
            }
        }

        $result['model'] = $model->findAll($input['iDisplayStart'], $input['iDisplayLength']);

        return $result;
    }

    public function getDetailPostById($id, $user_id)
    {
        $model = $this->select('post.name as postName, post.cat_id, post.is_type, post.price,
            post.province_id, post.district_id, post.contact_address, post.thumb_list, post.description,
            post.video, post.video_description, district.name as districtName, post.id')
            ->join('district', 'district.id = post.district_id')
            ->where('post.id', $id)
            ->where('post.user_id', $user_id);

        return $model->first();
    }

    public function getProductRelated($cat_id, $id)
    {
        $model = $this->select('post.thumb_list, post.id, post.name, post.created_at, post.slug,
        category.slug as catSlug')
            ->join('category', 'category.id = post.cat_id')
            ->where('post.status', STATUS_ACTIVE)
            ->where('post.cat_id', $cat_id)
            ->where('post.id !=', $id)
            ->orderBy('post.created_at', 'desc');

        return $model->findAll(5);
    }

    public function getListFavorites($user_id, $count = false)
    {
        $model = $this->select('post.name, post.thumb_list, post.id, post.slug, category.slug as catSlug, post.price,
            users.fullname')
            ->join('users_favorites', 'users_favorites.post_id = post.id')
            ->join('category', 'category.id = post.cat_id')
            ->join('users', 'users.id = post.user_id')
            ->where('users_favorites.user_id', $user_id)
            ->where('category.status', STATUS_ACTIVE)
            ->where('post.status', STATUS_POST_ACTIVE)
            ->where('post.expire_to >=', date('Y-m-d'))
            ->where('post.user_id <>', $user_id)
            ->orderBy('users_favorites.created_at', 'desc');
            if ($count) {
                $model = $model->findAll();
            } else {
                $model = $model->findAll(4);
            }

            return $model;
    }

    public function getListFavoritesManager($input = array(), $user_id)
    {
        $model = $this->select('post.id, post.name, post.cat_id, post.province_id, post.price,
            post.slug, post.status, post.featured, category.name as catName, province.name as provinceName,
            post.thumb_list, post.expire_from, post.expire_to, category.slug as catSlug, post.slug,
            users.gender, users.fullname as userName, users.email,
            users_favorites.id as favoritesId')
            ->join('users_favorites', 'users_favorites.post_id = post.id')
            ->join('category', 'category.id = post.cat_id')
            ->join('users', 'users.id = post.user_id')
            ->join('province', 'province.id = post.province_id')
            ->where('users_favorites.user_id', $user_id)
            ->where('post.status', STATUS_POST_ACTIVE)
            ->where('post.user_id <>', $user_id)
            ->where('post.expire_to >=', date('Y-m-d'))
            ->where('category.status', STATUS_ACTIVE)
            ->orderBy('users_favorites.created_at', 'desc');

        if (isset($input['iSortCol_0'])) {
            $sorting_mapping_array = array(
                '2' => 'post.name',
                '3' => 'post.created_at',
                '5' => 'post.created_at',
            );

            $order = "desc";
            if (isset($input['sSortDir_0'])) {
                $order = $input['sSortDir_0'];
            }

            if (isset($sorting_mapping_array[$input['iSortCol_0']])) {
                $model->orderBy($sorting_mapping_array[$input['iSortCol_0']], $order);
            }
        }

        $result['model'] = $model->findAll($input['iDisplayStart'], $input['iDisplayLength']);

        return $result;
    }

    public function getListPostByUser($user_id)
    {
        return $this->select('post.id')
            ->join('category', 'category.id = post.cat_id')
            ->where('post.status', STATUS_POST_ACTIVE)
            ->where('post.user_id', $user_id)
            ->where('post.expire_to >=', date('Y-m-d'))
            ->where('category.status', STATUS_ACTIVE)
            ->findAll();
    }
}
