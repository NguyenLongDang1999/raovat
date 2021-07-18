<?php

namespace App\Models;

use CodeIgniter\Model;

class Banner extends Model
{
    protected $table                = 'banner';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = true;

    protected $allowedFields        = [
        'name',
        'url',
        'description',
        'image',
        'cat_id',
        'orders',
        'status',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps        = true;
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';
    protected $deletedField         = 'deleted_at';

    public function getList($input = array())
    {
        $model = $this->select('id, name, image, orders, status, created_at');

        if (isset($input['search']['name']) && $input['search']['name'] != "") {
            $model->like('name', trim($input['search']['name']));
        }

        if (isset($input['search']['status']) && $input['search']['status'] != "") {
            $model->where('status', $input['search']['status']);
        }

        if (isset($input['search']['cat_id']) && $input['search']['cat_id'] != "") {
            $model->where('cat_id', $input['search']['cat_id']);
        }

        if (isset($input['search']['orders']) && $input['search']['orders'] != "") {
            $model->where('orders', $input['search']['orders']);
        }

        $result['total'] = $model->countAllResults(false);

        if (isset($input['iSortCol_0'])) {
            $sorting_mapping_array = array(
                '6' => 'created_at',
            );

            $order = "desc";
            if (isset($input['sSortDir_0'])) {
                $order = $input['sSortDir_0'];
            }

            if (isset($sorting_mapping_array[$input['iSortCol_0']])) {
                $model->orderBy($sorting_mapping_array[$input['iSortCol_0']], $order);
            }
        }

        $model = $model->findAll($input['iDisplayStart'], $input['iDisplayLength']);

        $result['model'] = $model;

        return $result;
    }

    public function getListRecycle($input = array())
    {
        $model = $this->select('id, name, image, orders, created_at, updated_at')
            ->onlyDeleted();

        $result['total'] = $model->countAllResults(false);
        
        if (isset($input['iSortCol_0'])) {
            $sorting_mapping_array = array(
                '5' => 'created_at',
            );

            $order = "desc";
            if (isset($input['sSortDir_0'])) {
                $order = $input['sSortDir_0'];
            }

            if (isset($sorting_mapping_array[$input['iSortCol_0']])) {
                $model->orderBy($sorting_mapping_array[$input['iSortCol_0']], $order);
            }
        }

        $model = $model->findAll($input['iDisplayStart'], $input['iDisplayLength']);

        $result['model'] = $model;

        return $result;
    }

    public function getMultiImageBanner($id)
    {
        return $this->select('image')->whereIn('id', $id)->withDeleted()->findAll();
    }

    public function getDetailBanner($id, $recycle = false)
    {
        $model = $this->select('id, name, url, description, cat_id, orders, image');

        if ($recycle) {
            $model->withDeleted();
        }

        return $model->find($id);
    }

    public function checkExists($url)
    {
        $model = $this->select('url')
            ->where('url', $url)
            ->countAllResults();

        return $model;
    }
}
