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

    protected $allowedFields        = [
        'name',
        'slug',
        'description',
        'image',
        'parent_id',
        'status',
        'meta_description',
        'meta_keyword',
        'deleted_at'
    ];

    // Dates
    protected $useTimestamps        = true;
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

    public function getListRecycle($input = array())
    {
        $model = $this->select('id, name, parent_id, status, created_at, updated_at')
            ->onlyDeleted();

        if (isset($input['iSortCol_0'])) {
            $sorting_mapping_array = array(
                '2' => 'name',
                '4' => 'created_at',
                '5' => 'updated_at',
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

    public function getDetailCategory($id, $recycle = false)
    {
        $model = $this->select('id, name, parent_id, description, meta_keyword, meta_description, image');

        if ($recycle) {
            $model->withDeleted();
        }

        return $model->find($id);
    }

    public function checkParentCategory($id, $recycle = false)
    {
        $model = $this->select('id')
            ->whereIn('parent_id', $id);

        if ($recycle) {
            $model->withDeleted();
        }

        $model = $model->countAllResults();
        return $model;
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

    public function checkExists($slug)
    {
        $model = $this->select('slug')
            ->where('slug', $slug)
            ->countAllResults();

        return $model;
    }

    public function getShowCategory($slug, $id)
    {
        $model = $this->select('id, slug, name, parent_id, description, meta_keyword, meta_description, image')
            ->where('status', STATUS_ACTIVE)
            ->where('slug', $slug);

        return $model->find($id);
    }

    public function categoryBreadcrumbs($id)
    {
        return $this->select('id, name, parent_id, slug')
            ->where('id', $id)
            ->where('status', STATUS_ACTIVE)
            ->get()
            ->getRowArray();
    }

    public function getCategoryList($parent_id = 0)
    {
        return $this->select('name, slug, image, id')
            ->where('status', STATUS_ACTIVE)
            ->where('parent_id', $parent_id)
            ->findAll();
    }

    public function getCategoryRecursive($parent_id)
    {
        $listCatId = array($parent_id);
        $model = $this->getCategoryList($parent_id);
        foreach ($model as $row) {
            $listCatId = array_merge($listCatId, $this->getCategoryRecursive($row["id"]));
        }

        return $listCatId;
    }

    public function show_breadcumb($id, $detail = false)
    {
        $row = $this->categoryBreadcrumbs($id);
        $uri = service('uri');

        if ($row['parent_id'] == 0) {
            return '<li class="breadcrumb-item text-capitalize active" aria-current="page"><a href="' . route_to('user.category.category', $row['slug'], $row['id']) . '">' . esc($row['name']) . '</a></li>';
        } else {
            if ($detail) {
                $html = '<li class="breadcrumb-item text-capitalize"><a href="' . route_to('user.category.category', esc($row['slug']), esc($row['id'])) . '">' . esc($row['name']) . '</a></li>';
            } else {
                if ($uri->getSegment(1) == $row['slug']) {
                    $html = '<li class="breadcrumb-item text-capitalize active" aria-current="page">' . esc($row['name']) . '</li>';
                } else {
                    $html = '<li class="breadcrumb-item text-capitalize"><a href="' . route_to('user.category.category', esc($row['slug']), esc($row['id'])) . '">' . esc($row['name']) . '</a></li>';
                }
            }

            return $this->show_breadcumb(esc($row['parent_id'])) . $html;
        }
    }
}
