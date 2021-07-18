<?php

namespace App\Models;

use CodeIgniter\Model;

class Pages extends Model
{
    protected $table                = 'pages';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    protected $useSoftDeletes       = false;

    protected $allowedFields        = [
        'name',
        'url',
        'description',
        'meta_keyword',
        'meta_description',
        'status'
    ];

    // Dates
    protected $useTimestamps        = true;
    protected $createdField         = 'created_at';
    protected $updatedField         = 'updated_at';

    public function getList($input = array())
    {
        $model = $this->select('id, name, url, status, created_at');

        if (isset($input['search']['name']) && $input['search']['name'] != "") {
            $model->like('name', trim($input['search']['name']));
        }

        if (isset($input['search']['status']) && $input['search']['status'] != "") {
            $model->where('status', $input['search']['status']);
        }

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
        $result['total'] = count($model);

        return $result;
    }

    public function getDetailPages($id)
    {
        return $this->select('id, name, url, description, meta_keyword, meta_description')->find($id);
    }

    public function getAllPages()
    {
        return $this->select('name, url')->findAll(5);
    }

    public function getDetailByUrl($url)
    {
        return $this->select('name, description, meta_keyword, meta_description')
            ->where('url', $url)
            ->first();
    }
}
