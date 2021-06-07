<?php

namespace App\Models;

use CodeIgniter\Model;

class Category extends Model
{
	protected $table                = 'category';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $returnType           = 'array';
	protected $useSoftDeletes       = true;
	protected $allowedFields        = [];

	// Dates
	protected $useTimestamps        = true;
	protected $dateFormat           = 'datetime';
	protected $createdField         = 'created_at';
	protected $updatedField         = 'updated_at';
	protected $deletedField         = 'deleted_at';


	public function getList($input = array())
	{
		$model = $this->select('id, name, parent_id, status, created_at, updated_at');
		if (isset($input['search']['name']) && $input['search']['name'] != "") {
			$model->like('name', trim($input['search']['name']));
		}

		if (isset($input['search']['status']) && $input['search']['status'] != "") {
			$model->where('status', $input['search']['status']);
		}

		if (isset($input['iSortCol_0'])) {
			$sorting_mapping_array = array(
				'2' => 'name',
				'5' => 'created_at',
				'6' => 'updated_at',
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

	public function getTreeCategory($parent_id = 0, $char = '', $option = '')
	{
		if (!is_array($option)) {
			$option = ['' => 'Vui Lòng Chọn', '0' => 'Danh mục cha'];
		}

		$model = $this->select('id, name')
			->where('parent_id', $parent_id)
			->where('status', STATUS_ACTIVE)
			->findAll();

		foreach ($model as $item) {
			$option[$item['id']] = $char . esc($item['name']);
			$option = $this->getTreeCategory($item['id'], $char . '|--- ', $option);
		}

		return $option;
	}
}
