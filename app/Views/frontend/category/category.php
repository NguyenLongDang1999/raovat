<?= $this->extend('templates/frontend/master'); ?>

<?= $this->section('title'); ?>
<?= esc($row['name']) ?>
<?= $this->endSection(); ?>

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/pages/app-ecommerce.min.css') ?>
<style>
    @media (max-width: 575.98px) {

        .ecommerce-application .grid-view,
        .ecommerce-application .grid-view.wishlist-items {
            grid-template-columns: 1fr 1fr;
        }
    }

    @media (min-width: 675.98px) and (max-width: 991.98px) {
        .ecommerce-application .grid-view {
            grid-template-columns: 1fr 1fr 1fr;
        }
    }

    @media (max-width: 375.98px) {

        .ecommerce-application .grid-view,
        .ecommerce-application .grid-view.wishlist-items {
            grid-template-columns: 1fr;
        }
    }
</style>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<?= script_tag('app-assets/js/scripts/pages/app-ecommerce.min.js') ?>
<?= $this->endSection() ?>
<!-- end pageJS -->

<!-- Content-header -->
<?= $this->section('content-header'); ?>
<div class="content-header-left col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <section id="default-breadcrumb">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <nav>
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= route_to('user.home.index') ?>">Trang
                                                Chủ</a></li>
                                        <?= $breadcrumbs ?>
                                    </ol>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
<!-- end Content-header -->

<!-- Content-body -->
<?= $this->section('content-body'); ?>
<div class="text-center">
    <h1 class="mt-2 text-capitalize"><?= esc($row['name']) ?></h1>
    <p class="mb-2 pb-75 text-capitalize">
        <?= esc($row['description']) ?>
    </p>
</div>
<?php if (count($getPostShowByCat)) : ?>
<section id="ecommerce-header">
    <div class="row">
        <div class="col-sm-12">
            <div class="ecommerce-header-items">
                <div class="result-toggler">
                    <button class="navbar-toggler shop-sidebar-toggler" type="button" data-toggle="collapse">
                        <span class="navbar-toggler-icon d-block d-lg-none"><i data-feather="menu"></i></span>
                    </button>
                    <div class="search-results text-capitalize">Hiển thị <?= $countPost ?> bài đăng</div>
                </div>
                <div class="view-options d-flex">
                    <div class="btn-group dropdown-sort">
                        <button type="button" class="btn btn-outline-primary dropdown-toggle mr-1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="active-sorting">Featured</span>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item" href="javascript:void(0);">Featured</a>
                            <a class="dropdown-item" href="javascript:void(0);">Lowest</a>
                            <a class="dropdown-item" href="javascript:void(0);">Highest</a>
                        </div>
                    </div>
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                        <label class="btn btn-icon btn-outline-primary view-btn grid-view-btn">
                            <input type="radio" name="radio_options" id="radio_option1" checked />
                            <i data-feather="grid" class="font-medium-3"></i>
                        </label>
                        <label class="btn btn-icon btn-outline-primary view-btn list-view-btn d-md-block d-none">
                            <input type="radio" name="radio_options" id="radio_option2" />
                            <i data-feather="list" class="font-medium-3"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="body-content-overlay"></div>
<?php if (count($getPostShowByCat)) : ?>
    <section id="ecommerce-products" class="grid-view">
        <?php foreach ($getPostShowByCat as $item) : ?>
            <?php $img = explode(',', $item['thumb_list']); ?>
            <div class="card ecommerce-card mb-75">
                <div class="text-center">
                    <a href="<?= route_to('user.post.detail', esc($item['catSlug']), esc($item['slug']), esc($item['id'])) ?>">
                        <?php if (!empty($img[0])) : ?>
                            <?= img(PATH_POST_SMALL_IMAGE . $img[0], false, ['class' => 'card-img-top img-fluid h-100', 'width' => 350, 'height' => 250, 'alt' => esc($item['name'])]) ?>
                        <?php else : ?>
                            <?= img('app-assets/images/no-image.jpg', false, ['class' => 'card-img-top img-fluid h-100', 'width' => 350, 'height' => 250, 'alt' => esc($item['name'])]) ?>
                        <?php endif; ?>
                    </a>
                </div>
                <div class="card-body">
                    <div class="item-wrapper">
                        <div>
                            <h6 class="item-price"><?= esc(number_to_amount($item['price'], 2, 'vi_VN')) ?></h6>
                        </div>
                    </div>
                    <h6 class="item-name">
                        <a class="text-body text-capitalize" href="<?= route_to('user.post.detail', esc($item['catSlug']), esc($item['slug']), esc($item['id'])) ?>"><?= esc($item['name']) ?></a>
                    </h6>
                    <div class="media order-2 my-50">
                        <div class="avatar mr-50">
                            <?php if (is_null($item['avatar'])) : ?>
                                <?= img(PATH_DEFAULT_AVATAR, false, ['width' => 24, 'height' => 24, 'alt' => esc($item['fullname'])]) ?>
                            <?php else : ?>
                                <?= img(PATH_USER_IMAGE . $item['avatar'], false, ['width' => 24, 'height' => 24, 'alt' => esc($item['fullname'])]) ?>
                            <?php endif ?>
                        </div>
                        <div class="media-body">
                            <small><a href="javascript:void(0);" class="text-body"><?= esc($item['fullname']) ?></a></small>
                            <span class="text-muted ml-50 mr-25">|</span>
                            <small class="text-muted"><?= getDateHumanize($item['created_at']) ?></small>
                        </div>
                    </div>
                    <div class="my-50 py-25 order-3">
                        <a href="javascript:void(0);">
                            <div class="badge badge-pill badge-light-primary"><?= esc($item['provinceName']) ?></div>
                        </a>
                        <a href="javascript:void(0);">
                            <div class="badge badge-pill badge-light-danger"><?= esc($item['districtName']) ?></div>
                        </a>
                    </div>
                    <div class="my-50 py-25 order-4">
                        <i data-feather='eye'></i>
                        <?= esc($item['view']) ?> 
                        <span>Lượt Xem</span>
                    </div>
                </div>
                <div class="item-options text-center">
                    <div class="item-wrapper">
                        <div class="item-cost">
                            <h4 class="item-price"><?= esc(number_to_amount($item['price'], 2, 'vi_VN')) ?></h4>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="btn btn-light btn-wishlist">
                        <i data-feather="heart"></i>
                        <span>Lưu Tin</span>
                    </a>
                    <a href="javascript:void(0)" class="btn btn-primary btn-cart">
                        <span>Đọc Thêm</span>
                    </a>
                </div>
            </div>
        <?php endforeach ?>
    </section>
    <section id="ecommerce-pagination">
        <div class="row">
            <div class="col-sm-12">
                <?= $pager->links() ?>
            </div>
        </div>
    </section>
<?php endif; ?>
</div>
</div>
<div class="sidebar-detached sidebar-left">
    <div class="sidebar">
        <div class="sidebar-shop">
            <div class="row">
                <div class="col-sm-12">
                    <h6 class="filter-heading d-none d-lg-block text-capitalize">Lọc bài đăng</h6>
                </div>
            </div>
            <div class="card">
                <?= form_open('', ['method' => 'GET', 'id' => 'filter-category']) ?>
                <div class="card-body">
                    <div class="multi-range-price">
                        <h6 class="filter-title mt-0">Giá Cả</h6>
                        <ul class="list-unstyled price-range" id="price-range">
                            <li>
                                <div class="custom-control custom-radio">
                                    <?= form_radio('price_range', '', true, ['class' => 'custom-control-input', 'id' => 'priceAll']) ?>
                                    <?= form_label('ALL', 'priceAll', ['class' => 'custom-control-label']) ?>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-radio">
                                    <?= form_radio('price_range', '1', (isset($input['price_range']) && $input['price_range'] == 1) ? true : false, ['class' => 'custom-control-input', 'id' => 'priceRange1']) ?>
                                    <?= form_label('<= 1 Triệu', 'priceRange1', ['class' => 'custom-control-label']) ?>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-radio">
                                    <?= form_radio('price_range', '2', (isset($input['price_range']) && $input['price_range'] == 2) ? true : false, ['class' => 'custom-control-input', 'id' => 'priceRange2']) ?>
                                    <?= form_label('1 - 100 Triệu', 'priceRange2', ['class' => 'custom-control-label']) ?>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-radio">
                                    <?= form_radio('price_range', '3', (isset($input['price_range']) && $input['price_range'] == 3) ? true : false, ['class' => 'custom-control-input', 'id' => 'priceRange3']) ?>
                                    <?= form_label('100 Triệu - 1 Tỷ', 'priceRange3', ['class' => 'custom-control-label']) ?>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-radio">
                                    <?= form_radio('price_range', '4', (isset($input['price_range']) && $input['price_range'] == 4) ? true : false, ['class' => 'custom-control-input', 'id' => 'priceRange4']) ?>
                                    <?= form_label('>= 1 Tỷ', 'priceRange4', ['class' => 'custom-control-label']) ?>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div id="product-categories">
                        <h6 class="filter-title">Hình Thức</h6>
                        <ul class="list-unstyled categories-list">
                            <li>
                                <div class="custom-control custom-radio">
                                    <?= form_radio('is_type_filter', '', true, ['class' => 'custom-control-input', 'id' => 'is-type']) ?>
                                    <?= form_label('ALL', 'is-type', ['class' => 'custom-control-label']) ?>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-radio">
                                    <?= form_radio('is_type_filter', '0', (isset($input['is_type_filter']) && $input['is_type_filter'] == 0) ? true : false, ['class' => 'custom-control-input', 'id' => 'is-type-0']) ?>
                                    <?= form_label('Cần Bán', 'is-type-0', ['class' => 'custom-control-label']) ?>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-radio">
                                    <?= form_radio('is_type_filter', '1', (isset($input['is_type_filter']) && $input['is_type_filter'] == 1) ? true : false, ['class' => 'custom-control-input', 'id' => 'is-type-1']) ?>
                                    <?= form_label('Cần Mua', 'is-type-1', ['class' => 'custom-control-label']) ?>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-radio">
                                    <?= form_radio('is_type_filter', '2', (isset($input['is_type_filter']) && $input['is_type_filter'] == 2) ? true : false, ['class' => 'custom-control-input', 'id' => 'is-type-2']) ?>
                                    <?= form_label('Cần Thuê', 'is-type-2', ['class' => 'custom-control-label']) ?>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-radio">
                                    <?= form_radio('is_type_filter', '3', (isset($input['is_type_filter']) && $input['is_type_filter'] == 3) ? true : false, ['class' => 'custom-control-input', 'id' => 'is-type-3']) ?>
                                    <?= form_label('Cho Thuê', 'is-type-3', ['class' => 'custom-control-label']) ?>
                                </div>
                            </li>
                            <li>
                                <div class="custom-control custom-radio">
                                    <?= form_radio('is_type_filter', '4', (isset($input['is_type_filter']) && $input['is_type_filter'] == 4) ? true : false, ['class' => 'custom-control-input', 'id' => 'is-type-4']) ?>
                                    <?= form_label('Khác', 'is-type-4', ['class' => 'custom-control-label']) ?>
                                </div>
                            </li>
                        </ul>
                    </div>

                    <div class="brands">
                        <h6 class="filter-title">Brands</h6>
                        <ul class="list-unstyled brand-list">
                            <li>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="productBrand1" />
                                    <label class="custom-control-label" for="productBrand1">Insignia™</label>
                                </div>
                                <span>746</span>
                            </li>
                            <li>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="productBrand2" checked />
                                    <label class="custom-control-label" for="productBrand2">Samsung</label>
                                </div>
                                <span>633</span>
                            </li>
                            <li>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="productBrand3" />
                                    <label class="custom-control-label" for="productBrand3">Metra</label>
                                </div>
                                <span>591</span>
                            </li>
                            <li>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="productBrand4" />
                                    <label class="custom-control-label" for="productBrand4">HP</label>
                                </div>
                                <span>530</span>
                            </li>
                            <li>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="productBrand5" checked />
                                    <label class="custom-control-label" for="productBrand5">Apple</label>
                                </div>
                                <span>442</span>
                            </li>
                            <li>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="productBrand6" />
                                    <label class="custom-control-label" for="productBrand6">GE</label>
                                </div>
                                <span>394</span>
                            </li>
                            <li>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="productBrand7" />
                                    <label class="custom-control-label" for="productBrand7">Sony</label>
                                </div>
                                <span>350</span>
                            </li>
                            <li>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="productBrand8" />
                                    <label class="custom-control-label" for="productBrand8">Incipio</label>
                                </div>
                                <span>320</span>
                            </li>
                            <li>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="productBrand9" />
                                    <label class="custom-control-label" for="productBrand9">KitchenAid</label>
                                </div>
                                <span>318</span>
                            </li>
                            <li>
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" class="custom-control-input" id="productBrand10" />
                                    <label class="custom-control-label" for="productBrand10">Whirlpool</label>
                                </div>
                                <span>298</span>
                            </li>
                        </ul>
                    </div>

                    <?= form_submit(NULL, 'Submit', ['class' => 'btn btn-block btn-primary']) ?>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?php else: ?>
    
<?php endif; ?>
<?= $this->endSection(); ?>
<!-- end Content-body -->