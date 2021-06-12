<?php

namespace App\Models;

use CodeIgniter\Model;

class Province extends Model
{
	protected $table                = 'province';
	protected $primaryKey           = 'id';
	protected $useAutoIncrement     = true;
	protected $returnType           = 'array';

	public function getProvince()
	{
		$model = $this->select('id, name')
			->findAll();

		$option[''] = '';

		foreach ($model as $item) {
			$option[$item['id']] = $item['name'];
		}

		return $option;
	}
}
