<?= $this->extend('templates/frontend/master'); ?>

<?= $this->section('title'); ?>
Trang chủ
<?= $this->endSection(); ?>

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/pages/app-ecommerce.min.css') ?>
<style>
    @media (min-width: 992.98px) {
        .ecommerce-application .grid-view {
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
            column-gap: 1rem;
        }
    }

    @media (max-width: 575.98px) {

        .ecommerce-application .grid-view,
        .ecommerce-application .grid-view.wishlist-items {
            grid-template-columns: 1fr 1fr;
            column-gap: 1rem;
        }
    }

    @media (min-width: 675.98px) and (max-width: 991.98px) {
        .ecommerce-application .grid-view {
            grid-template-columns: 1fr 1fr 1fr 1fr;
            column-gap: 1rem;
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

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/lazy/jquery.lazy.min.js') ?>
<?= script_tag('app-assets/vendors/js/lazy/jquery.lazy.script.min.js') ?>
<script>
    $(function() {
        $('.lazy').lazy();
    })
</script>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- Content-body -->
<?= $this->section('content-body'); ?>
<section class="home-page">
    <?php if (count($getCategoryMenu) > 0) : ?>
        <div class="divider">
            <h4 class="divider-text text-capitalize font-medium-5">
                Danh mục rao vặt nổi bật
            </h4>
        </div>
        <div class="row">
            <?php foreach ($getCategoryMenu as $item) : ?>
                <div class="col-xl-2 col-md-4 col-6">
                    <div class="card text-center">
                        <div class="card-body">
                            <div class="avatar bg-light-info p-50 mb-1">
                                <div class="avatar-content">
                                    <a href="<?= route_to('user.category.category', $item['slug'], $item['id']) ?>">
                                        <?= img(PATH_CATEGORY_IMAGE . $item['image'], false, ['alt' => esc($item['name']), 'class' => 'round', 'width' => '45', 'height' => '45']) ?>
                                    </a>
                                </div>
                            </div>
                            <h4 class="font-weight-bolder text-truncate">
                                <a href="<?= route_to('user.category.category', $item['slug'], $item['id']) ?>" class="text-body text-capitalize" data-toggle="tooltip" data-placement="bottom" title="<?= esc($item['name']) ?>">
                                    <?= esc($item['name']) ?>
                                </a>
                            </h4>
                            <p class="card-text text-truncate"><?= esc($item['description']) ?></p>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif; ?>

    <?php if (count($getPostFeatured) > 0) : ?>
        <div class="divider">
            <h4 class="divider-text text-capitalize font-medium-5 font-weight-bolder">
                Bài đăng VIP
            </h4>
        </div>
        <div class="grid-view">
            <?php foreach ($getPostFeatured as $item) : ?>
                <?php $img = explode(',', $item['thumb_list']); ?>
                <div class="card ecommerce-card">
                    <div class="text-center">
                        <a href="<?= route_to('user.post.detail', esc($item['catSlug']), esc($item['slug']), esc($item['id'])) ?>">
                            <div class="position-relative">
                                <?php if (!empty($img[0])) : ?>
                                    <?= img(PATH_LAZY_LOADING, false, ['class' => 'card-img-top img-fluid lazy loading', 'width' => 350, 'height' => 250, 'alt' => esc($item['name']), 'data-src' => base_url(PATH_POST_SMALL_IMAGE . $img[0])]) ?>
                                <?php else : ?>
                                    <?= img(PATH_LAZY_LOADING, false, ['class' => 'card-img-top img-fluid lazy loading', 'width' => 350, 'height' => 250, 'alt' => esc($item['name']), 'data-src' => base_url('app-assets/images/no-image.jpg')]) ?>
                                <?php endif; ?>
                                <div class="position-absolute position-top-0">
                                    <span class="badge badge-primary p-75">
                                        <i data-feather="zap" class="mr-25"></i>
                                        HOT
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="item-wrapper">
                            <div>
                                <h6 class="item-price"><?= $item['price'] != 0 ? esc(number_to_amount($item['price'], 2, 'vi_VN')) : 'Thương Lượng' ?></h6>
                            </div>
                        </div>
                        <h6 class="item-name">
                            <a class="text-body text-capitalize" href="<?= route_to('user.post.detail', esc($item['catSlug']), esc($item['slug']), esc($item['id'])) ?>" data-toggle="tooltip" data-placement="bottom" title="<?= esc($item['name']) ?>"><?= esc($item['name']) ?></a>
                        </h6>
                        <div class="media order-2 my-50">
                            <div class="avatar mr-50">
                                <?= img(PATH_LAZY_LOADING, false, ['class' => 'lazy loading', 'width' => 24, 'height' => 24, 'alt' => esc($item['fullname']), 'data-src' => base_url(userShowImage($item['avatar'], $item['provider_name'], $item['provider_uid']))]) ?>
                            </div>
                            <div class="media-body">
                                <small><a href="javascript:void(0);" class="text-body"><?= esc($item['fullname']) ?></a></small>
                                <span class="text-muted ml-50 mr-25">|</span>
                                <small class="text-muted"><?= getDateHumanize($item['created_at']) ?></small>
                            </div>
                        </div>
                        <div class="my-50 py-25">
                            <a href="javascript:void(0);">
                                <div class="badge badge-pill badge-light-primary"><?= esc($item['provinceName']) ?></div>
                            </a>
                            <a href="javascript:void(0);">
                                <div class="badge badge-pill badge-light-danger"><?= esc($item['districtName']) ?></div>
                            </a>
                        </div>
                        <div class="my-50 py-25">
                            <i data-feather='eye'></i>
                            <?= esc($item['view']) ?>
                            <span>Lượt Xem</span>
                        </div>
                    </div>
                    <div class="item-options text-center">
                        <div class="item-wrapper">
                            <div class="item-cost">
                                <h4 class="item-price"><?= $item['price'] != 0 ? esc(number_to_amount($item['price'], 2, 'vi_VN')) : 'Thương Lượng' ?></h4>
                            </div>
                        </div>
                        <a href="javascript:void(0)" class="btn btn-light btn-wishlist">
                            <i data-feather="heart"></i>
                            <span>Lưu Tin</span>
                        </a>
                        <a href="<?= route_to('user.post.detail', esc($item['catSlug']), esc($item['slug']), esc($item['id'])) ?>" class="btn btn-primary btn-cart">
                            <span>Đọc Thêm</span>
                        </a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif; ?>

    <?php if (count($getPostNew) > 0) : ?>
        <div class="divider">
            <h4 class="divider-text text-capitalize font-medium-5 font-weight-bolder">
                Bài đăng mới nhất
            </h4>
        </div>
        <div class="grid-view">
            <?php foreach ($getPostNew as $item) : ?>
                <?php $img = explode(',', $item['thumb_list']); ?>
                <div class="card ecommerce-card">
                    <div class="text-center">
                        <a href="<?= route_to('user.post.detail', esc($item['catSlug']), esc($item['slug']), esc($item['id'])) ?>">
                            <?php if ($item['featured'] == FEATURED_INACTIVE) : ?>
                                <?php if (!empty($img[0])) : ?>
                                    <?= img(PATH_LAZY_LOADING, false, ['class' => 'card-img-top img-fluid lazy loading', 'width' => 350, 'height' => 250, 'alt' => esc($item['name']), 'data-src' => base_url(PATH_POST_SMALL_IMAGE . $img[0])]) ?>
                                <?php else : ?>
                                    <?= img(PATH_LAZY_LOADING, false, ['class' => 'card-img-top img-fluid lazy loading', 'width' => 350, 'height' => 250, 'alt' => esc($item['name']), 'data-src' => base_url('app-assets/images/no-image.jpg')]) ?>
                                <?php endif; ?>
                            <?php else : ?>
                                <div class="position-relative">
                                    <?php if (!empty($img[0])) : ?>
                                        <?= img(PATH_LAZY_LOADING, false, ['class' => 'card-img-top img-fluid lazy loading', 'width' => 350, 'height' => 250, 'alt' => esc($item['name']), 'data-src' => base_url(PATH_POST_SMALL_IMAGE . $img[0])]) ?>
                                    <?php else : ?>
                                        <?= img(PATH_LAZY_LOADING, false, ['class' => 'card-img-top img-fluid lazy loading', 'width' => 350, 'height' => 250, 'alt' => esc($item['name']), 'data-src' => base_url('app-assets/images/no-image.jpg')]) ?>
                                    <?php endif; ?>
                                    <div class="position-absolute position-top-0">
                                        <span class="badge badge-primary p-75">
                                            <i data-feather="zap" class="mr-25"></i>
                                            HOT
                                        </span>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </a>
                    </div>
                    <div class="card-body">
                        <div class="item-wrapper">
                            <div>
                                <h6 class="item-price"><?= $item['price'] != 0 ? esc(number_to_amount($item['price'], 2, 'vi_VN')) : 'Thương Lượng' ?></h6>
                            </div>
                        </div>
                        <h6 class="item-name">
                            <a class="text-body text-capitalize" href="<?= route_to('user.post.detail', esc($item['catSlug']), esc($item['slug']), esc($item['id'])) ?>" data-toggle="tooltip" data-placement="bottom" title="<?= esc($item['name']) ?>"><?= esc($item['name']) ?></a>
                        </h6>
                        <div class="media order-2 my-50">
                            <div class="avatar mr-50">
                                <?= img(PATH_LAZY_LOADING, false, ['class' => 'lazy loading', 'width' => 24, 'height' => 24, 'alt' => esc($item['fullname']), 'data-src' => base_url(userShowImage($item['avatar'], $item['provider_name'], $item['provider_uid']))]) ?>
                            </div>
                            <div class="media-body">
                                <small><a href="javascript:void(0);" class="text-body"><?= esc($item['fullname']) ?></a></small>
                                <span class="text-muted ml-50 mr-25">|</span>
                                <small class="text-muted"><?= getDateHumanize($item['created_at']) ?></small>
                            </div>
                        </div>
                        <div class="my-50 py-25">
                            <a href="javascript:void(0);">
                                <div class="badge badge-pill badge-light-primary"><?= esc($item['provinceName']) ?></div>
                            </a>
                            <a href="javascript:void(0);">
                                <div class="badge badge-pill badge-light-danger"><?= esc($item['districtName']) ?></div>
                            </a>
                        </div>
                        <div class="my-50 py-25">
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
                        <a href="<?= route_to('user.post.detail', esc($item['catSlug']), esc($item['slug']), esc($item['id'])) ?>" class="btn btn-primary btn-cart">
                            <span>Đọc Thêm</span>
                        </a>
                    </div>
                </div>
            <?php endforeach ?>
        </div>
    <?php endif; ?>
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->