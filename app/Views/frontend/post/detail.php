<?= $this->extend('templates/frontend/master'); ?>

<?= $this->section('title'); ?>
<?= esc($row['name']) ?>
<?= $this->endSection(); ?>

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/extensions/swiper.min.css') ?>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/pages/page-blog.min.css') ?>
<?= link_tag('app-assets/css/plugins/extensions/ext-component-swiper.min.css') ?>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/extensions/swiper.min.js') ?>
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
                                        <li class="breadcrumb-item text-capitalize active" aria-current="page"><?= esc($row['name']) ?></li>
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
<div class="blog-detail-wrapper">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
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
                                    <a href="<?= base_url(PATH_POST_SMALL_IMAGE . $img) ?>" data-fancybox="gallery">
                                        <?= img(PATH_POST_SMALL_IMAGE . $img, false, ['class' => 'img-fluid', 'alt' => esc($row['name'])]) ?>
                                    </a>
                                </div>
                            <?php endforeach ?>
                        </div>
                    </div>
                    <h1 class="card-title text-capitalize mt-3"><?= esc($row['name']) ?></h1>
                    <div class="my-1 py-25">
                        <a href="javascript:void(0);">
                            <div class="badge badge-pill badge-light-danger mr-50">Gaming</div>
                        </a>
                        <a href="javascript:void(0);">
                            <div class="badge badge-pill badge-light-warning">Video</div>
                        </a>
                    </div>
                    <p class="card-text mb-2">
                        <?= $row['description'] ?>
                    </p>
                    <hr class="my-2" />
                    <div class="media">
                        <div class="avatar mr-2">
                            <?php if (is_null($row['avatar'])) : ?>
                                <?= img(PATH_DEFAULT_AVATAR, false, ['width' => 60, 'height' => 60, 'alt' => esc($row['fullname'])]) ?>
                            <?php else : ?>
                                <?= img(PATH_USER_IMAGE . $row['avatar'], false, ['width' => 60, 'height' => 60, 'alt' => esc($row['fullname'])]) ?>
                            <?php endif ?>
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
                    <hr class="my-2" />
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <div class="d-flex align-items-center mr-1">
                                <a href="javascript:void(0);" class="mr-50">
                                    <i data-feather="message-square" class="font-medium-5 text-body align-middle"></i>
                                </a>
                                <a href="javascript:void(0);">
                                    <div class="text-body align-middle">19.1K</div>
                                </a>
                            </div>
                            <div class="d-flex align-items-center">
                                <a href="javascript:void(0);" class="mr-50">
                                    <i data-feather="bookmark" class="font-medium-5 text-body align-middle"></i>
                                </a>
                                <a href="javascript:void(0);">
                                    <div class="text-body align-middle">139</div>
                                </a>
                            </div>
                        </div>
                        <div class="dropdown blog-detail-share">
                            <i data-feather="share-2" class="font-medium-5 text-body cursor-pointer" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>
                            <div class="dropdown-menu dropdown-menu-right">
                                <a href="javascript:void(0);" class="dropdown-item py-50 px-1">
                                    <i data-feather="github" class="font-medium-3"></i>
                                </a>
                                <a href="javascript:void(0);" class="dropdown-item py-50 px-1">
                                    <i data-feather="gitlab" class="font-medium-3"></i>
                                </a>
                                <a href="javascript:void(0);" class="dropdown-item py-50 px-1">
                                    <i data-feather="facebook" class="font-medium-3"></i>
                                </a>
                                <a href="javascript:void(0);" class="dropdown-item py-50 px-1">
                                    <i data-feather="twitter" class="font-medium-3"></i>
                                </a>
                                <a href="javascript:void(0);" class="dropdown-item py-50 px-1">
                                    <i data-feather="linkedin" class="font-medium-3"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Blog -->

        <!-- Blog Comment -->
        <div class="col-12 mt-1" id="blogComment">
            <h6 class="section-label mt-25">Comment</h6>
            <div class="card">
                <div class="card-body">
                    <div class="media">
                        <div class="avatar mr-75">
                            <img src="../../../app-assets/images/portrait/small/avatar-s-9.jpg" width="38" height="38" alt="Avatar" />
                        </div>
                        <div class="media-body">
                            <h6 class="font-weight-bolder mb-25">Chad Alexander</h6>
                            <p class="card-text">May 24, 2020</p>
                            <p class="card-text">
                                A variation on the question technique above, the multiple-choice question great way to engage your
                                reader.
                            </p>
                            <a href="javascript:void(0);">
                                <div class="d-inline-flex align-items-center">
                                    <i data-feather="corner-up-left" class="font-medium-3 mr-50"></i>
                                    <span>Reply</span>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--/ Blog Comment -->

        <!-- Leave a Blog Comment -->
        <div class="col-12 mt-1">
            <h6 class="section-label mt-25">Leave a Comment</h6>
            <div class="card">
                <div class="card-body">
                    <form action="javascript:void(0);" class="form">
                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <div class="form-group mb-2">
                                    <input type="text" class="form-control" placeholder="Name" />
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <div class="form-group mb-2">
                                    <input type="email" class="form-control" placeholder="Email" />
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <div class="form-group mb-2">
                                    <input type="url" class="form-control" placeholder="Website" />
                                </div>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control mb-2" rows="4" placeholder="Comment"></textarea>
                            </div>
                            <div class="col-12">
                                <div class="custom-control custom-checkbox mb-2">
                                    <input type="checkbox" class="custom-control-input" id="blogCheckbox" />
                                    <label class="custom-control-label" for="blogCheckbox">Save my name, email, and website in this browser for the next time I comment.</label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Post Comment</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--/ Leave a Blog Comment -->
    </div>
</div>
<!--/ Blog Detail -->

</div>
</div>
<div class="sidebar-detached sidebar-right">
    <div class="sidebar">
        <div class="blog-sidebar mb-2 my-lg-0">
            <div class="blog-recent-posts">
                <h6 class="section-label">Recent Posts</h6>
                <div class="mt-75">
                    <div class="media mb-2">
                        <a href="page-blog-detail.html" class="mr-2">
                            <img class="rounded" src="../../../app-assets/images/banner/banner-22.jpg" width="100" height="70" alt="Recent Post Pic" />
                        </a>
                        <div class="media-body">
                            <h6 class="blog-recent-post-title">
                                <a href="page-blog-detail.html" class="text-body-heading">Why Should Forget Facebook?</a>
                            </h6>
                            <div class="text-muted mb-0">Jan 14 2020</div>
                        </div>
                    </div>
                    <div class="media mb-2">
                        <a href="page-blog-detail.html" class="mr-2">
                            <img class="rounded" src="../../../app-assets/images/banner/banner-27.jpg" width="100" height="70" alt="Recent Post Pic" />
                        </a>
                        <div class="media-body">
                            <h6 class="blog-recent-post-title">
                                <a href="page-blog-detail.html" class="text-body-heading">Publish your passions, your way</a>
                            </h6>
                            <div class="text-muted mb-0">Mar 04 2020</div>
                        </div>
                    </div>
                    <div class="media mb-2">
                        <a href="page-blog-detail.html" class="mr-2">
                            <img class="rounded" src="../../../app-assets/images/banner/banner-39.jpg" width="100" height="70" alt="Recent Post Pic" />
                        </a>
                        <div class="media-body">
                            <h6 class="blog-recent-post-title">
                                <a href="page-blog-detail.html" class="text-body-heading">The Best Ways to Retain More</a>
                            </h6>
                            <div class="text-muted mb-0">Feb 18 2020</div>
                        </div>
                    </div>
                    <div class="media">
                        <a href="page-blog-detail.html" class="mr-2">
                            <img class="rounded" src="../../../app-assets/images/banner/banner-35.jpg" width="100" height="70" alt="Recent Post Pic" />
                        </a>
                        <div class="media-body">
                            <h6 class="blog-recent-post-title">
                                <a href="page-blog-detail.html" class="text-body-heading">Share a Shocking Fact or Statistic</a>
                            </h6>
                            <div class="text-muted mb-0">Oct 08 2020</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<!-- end Content-body -->r