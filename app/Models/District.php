<?php

namespace App\Models;

use CodeIgniter\Model;

class District extends Model
{
	protected $table                = 'district';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $returnType           = 'array';

	public function getDistrict($provinceid)
	{
		$model = $this->select('id, name')
			->where('provinceid', $provinceid)
			->findAll();

		$option = '';
		foreach ($model as $item) {
			$option .= '<option value="' . $item['id'] . '">' . $item['name'] . '</option>';
		}

		return $option;
	}
}
