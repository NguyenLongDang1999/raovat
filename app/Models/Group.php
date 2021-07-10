<?php

namespace App\Models;

use CodeIgniter\Model;

class Group extends Model
{
    protected $table                = 'auth_groups';
    protected $primaryKey           = 'id';
    protected $useAutoIncrement     = true;
    protected $returnType           = 'array';
    
    protected $allowedFields        = [
        'name',
        'description',
    ];

    public function getList($input = array())
    {
        $model = $this->select('id, name, description');

        if (isset($input['iSortCol_0'])) {
            $sorting_mapping_array = array(
                '2' => 'name',
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

    public function getDetailGroup($id)
    {
        return $this->find($id);
    }
}
