<?php

namespace App\Controllers\Frontend;

use App\Controllers\BaseController;
use App\Libraries\Slug;
use App\Models\Post;
use App\Models\Category;
use App\Models\Province;
use App\Models\District;

class PostController extends BaseController
{
    protected $image;
    protected $slug;
    protected $post;
    protected $category;
    protected $province;
    protected $district;

    public function __construct()
    {
        $this->image = \Config\Services::image();
        $this->slug = new Slug();
        $this->post = new Post();
        $this->category = new Category();
        $this->province = new Province();
        $this->district = new District();
    }

    public function index()
    {
        $data['province'] = $this->province->getProvince();
        $category = $this->category->getTreeCategory();
        unset($category[0]);
        $data['category'] = $category;
        return view('frontend/post/create_edit', $data);
    }

    public function showDistrict()
    {
        if ($this->request->isAJAX()) {
            $province_id = $this->request->getPost('province_id');
            $data['getDistrict'] = $this->district->getDistrict($province_id);
            return json_encode($data);
        }
    }

    public function postPost()
    {
        $input = $this->request->getPost([
            'name',
            'cat_id',
            'is_type',
            'province_id',
            'district_id',
            'contact_address',
            'description',
            'video',
            'video_description'
        ]);

        $input['price'] = str_replace(',', '', $this->request->getPost('price'));
        // Date expire
        $daterange = $this->request->getPost('expire');
        $dates = explode(" - ", $daterange);

        $startDate = explode('/', $dates[0]);
        $endDate = explode('/', $dates[1]);

        $finalStartDate = $startDate[2] . '-' . $startDate[1] . '-' . $startDate[0];
        $finalEndDate = $endDate[2] . '-' . $endDate[1] . '-' . $endDate[0];

        $input['slug'] = $this->slug->str_slug($input['name']);
        $input['user_id'] = user()->id;
        $input['expire_from'] = $finalStartDate;
        $input['expire_to'] = $finalEndDate;

        // Upload Multiple Files
        $files = $this->request->getFiles();
        $thumb_list = '';

        if ($files) {
            foreach ($files['images'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $fileName = $file->getRandomName();
                    $file->move(PATH_POST_IMAGE, $fileName);

                    $parts = explode('.', $fileName);
                    $parts[count($parts) - 1] = 'webp';
                    $fileNameNew = implode('.', $parts);
                    $dataSmall = [
                        'resizeX' => '350',
                        'resizeY' => '250',
                        'ratio' => false,
                        'masterDim' => 'auto'
                    ];
                    imageManipulation(PATH_POST_IMAGE, $fileName, $fileNameNew, 'small', $dataSmall);
                    $dataMedium = [
                        'resizeX' => '650',
                        'resizeY' => '450',
                        'ratio' => false,
                        'masterDim' => 'auto'
                    ];
                    imageManipulation(PATH_POST_IMAGE, $fileName, $fileNameNew, 'medium', $dataMedium);
                    deleteImage(PATH_POST_IMAGE, $fileName);
                    $thumb_list .= $fileNameNew . ',';
                }
            }
            $thumb_list = rtrim($thumb_list, ',');
        }

        $input['thumb_list'] = $thumb_list;
        $this->post->insert($input);
        return redirect()->route('user.post.index')->with('message', "Bài đăng <strong class='text-capitalize'>" . esc($input['name']) . "</strong> đã được thêm. Vui lòng chờ kiểm duyệt.");
    }

    public function detail($catSlug, $postSlug, $id)
    {
        $row = $this->post->getDetailPostBySlug($catSlug, $postSlug, $id);
        // if ($data['row']['status'] != STATUS_POST_READY) {
        //     return redirect()->back()->with('error', "Tin đăng của bạn chưa được kiểm duyệt hoặc đã bị từ chối!");
        // }
        if (!isset($row)) {
            return redirect()->route('user.home.index');
        }
        $data['getCategoryList'] = $this->category->getCategoryList();
        $data['getProductRelated'] = $this->post->getProductRelated($row['cat_id'], $row['postId']);
        $data['gallery'] = explode(',', $row['thumb_list']);
        $input = [
            'view' => $row['view'] + 1
        ];
        $data['is_category_page'] = true;
        $data['breadcrumbs'] = $this->category->show_breadcumb($row['catId'], true);
        $this->post->update($row['postId'], $input);
        $data['row'] = $row;
        return view('frontend/post/detail', $data);
    }
}
