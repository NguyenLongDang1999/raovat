<?= $this->extend('templates/backend/master'); ?>

<?= $this->section('title'); ?>
Post List Page
<?= $this->endSection(); ?>

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/extensions/swiper.min.css') ?>
<?= link_tag('app-assets/vendors/css/fancybox/jquery.fancybox.min.css') ?>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/extensions/swiper.min.js') ?>
<?= script_tag('app-assets/vendors/js/fancybox/jquery.fancybox.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<script>
    $(function() {
        'use strict';

        var galleryThumbs = new Swiper('.gallery-thumbs', {
            spaceBetween: 10,
            slidesPerView: 4,
            freeMode: true,
            watchSlidesVisibility: true,
            watchSlidesProgress: true
        });
        var galleryTop = new Swiper('.gallery-top', {
            spaceBetween: 10,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            },
            thumbs: {
                swiper: galleryThumbs
            }
        });
    });
</script>
<?= $this->endSection() ?>
<!-- end pageJS -->

<!-- Content-body -->
<?= $this->section('content-body'); ?>
<div class="blog-detail-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h1 class="card-title text-capitalize mb-0"><?= esc($row['name']) ?></h1>
                    <div class="my-1 py-25">
                        <a href="javascript:void(0);">
                            <div class="badge badge-pill badge-light-primary"><?= esc($row['provinceName']) ?></div>
                        </a>
                        <a href="javascript:void(0);">
                            <div class="badge badge-pill badge-light-danger"><?= esc($row['districtName']) ?></div>
                        </a>
                    </div>
                    <p class="card-text text-capitalize">
                        Địa chỉ: <?= esc($row['contact_address']) ?>
                    </p>
                    <div class="row mb-3">
                        <div class="col-md-3 col-6 mb-2 mb-md-0">
                            <div class="media">
                                <div class="avatar bg-light-primary mr-2">
                                    <div class="avatar-content">
                                        <i data-feather="eye" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <h4 class="font-weight-bolder mb-0"><?= esc($row['view']) ?></h4>
                                    <p class="card-text font-small-3 mb-0">Lượt Xem</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-2 mb-md-0">
                            <div class="media">
                                <div class="avatar bg-light-info mr-2">
                                    <div class="avatar-content">
                                        <i data-feather="dollar-sign" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <?php if ($row['price'] != 0) : ?>
                                        <h4 class="font-weight-bolder mb-0"><?= esc(number_to_amount($row['price'], 2, 'vi_VN')) ?></h4>
                                        <p class="card-text font-small-3 mb-0">VNĐ</p>
                                    <?php else : ?>
                                        <h4 class="font-weight-bolder mb-0">Thương Lượng</h4>
                                        <p class="card-text font-small-3 mb-0">Giá Cả</p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6 mb-2 mb-md-0">
                            <div class="media">
                                <div class="avatar bg-light-danger mr-2">
                                    <div class="avatar-content">
                                        <i data-feather="clock" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <h4 class="font-weight-bolder mb-0"><?= getDateTime($row['created_at']) ?></h4>
                                    <p class="card-text font-small-3 mb-0">Ngày Đăng</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 col-6">
                            <div class="media">
                                <div class="avatar bg-light-success mr-2">
                                    <div class="avatar-content">
                                        <i data-feather="triangle" class="avatar-icon"></i>
                                    </div>
                                </div>
                                <div class="media-body my-auto">
                                    <h4 class="font-weight-bolder mb-0"><?= showIsTypePostDetail($row['is_type']) ?></h4>
                                    <p class="card-text font-small-3 mb-0">Hình Thức</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if (!empty($gallery[0])) : ?>
                        <div class="swiper-gallery swiper-container gallery-top">
                            <div class="swiper-wrapper text-center">
                                <?php foreach ($gallery as $img) : ?>
                                    <div class="swiper-slide">
                                        <a href="<?= base_url(PATH_POST_MEDIUM_IMAGE . $img) ?>" data-fancybox="gallery">
                                            <?= img(PATH_POST_MEDIUM_IMAGE . $img, false, ['class' => 'img-fluid', 'alt' => esc($row['name'])]) ?>
                                        </a>
                                    </div>
                                <?php endforeach ?>
                            </div>
                            <!-- Add Arrows -->
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                        <div class="swiper-container gallery-thumbs">
                            <div class="swiper-wrapper mt-25">
                                <?php foreach ($gallery as $img) : ?>
                                    <div class="swiper-slide">
                                        <?= img(PATH_POST_SMALL_IMAGE . $img, false, ['class' => 'img-fluid', 'alt' => esc($row['name'])]) ?>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php endif; ?>
                    <p class="card-text mb-2">
                        <?= $row['description'] ?>
                    </p>
                    <hr class="my-2" />
                    <div class="media">
                        <div class="avatar mr-2">
                            <?= img(userShowImage($row['avatar'], $row['provider_name'], $row['provider_uid']), false, ['width' => 60, 'height' => 60, 'alt' => esc($row['fullname'])]) ?>
                        </div>
                        <div class="media-body">
                            <h6 class="font-weight-bolder text-capitalize"><?= esc($row['fullname']) ?></h6>
                            <p class="card-text mb-0">
                                <i data-feather='phone-call'></i>
                                <span><?= esc($row['phone']) ?></span>
                            </p>
                            <p class="card-text mb-0">
                                <i data-feather='mail'></i>
                                <span><?= esc($row['email']) ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php if ($row['video'] != '' && $row['video_description'] != '') : ?>
            <div class="col-12 mt-1" id="blogVideo">
                <h6 class="section-label mt-25">Video</h6>
                <div class="card">
                    <div class="card-body">
                        <div class="title mb-2">
                            <p><?= esc($row['video_description']) ?></p>

                            <a data-fancybox href="<?= esc($row['video']) ?>">
                                <?= img(video_youtube(esc($row['video'])), false, ['class' => 'card-img-top img-fluid']) ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection(); ?>
<!-- end Content-body -->