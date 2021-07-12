<?= $this->extend('templates/frontend/master'); ?>

<?= $this->section('title'); ?>
<?= esc($row['name']) ?>
<?= $this->endSection(); ?>

<!-- metaSeo -->
<?= $this->section('metaSeo') ?>
<!--open graph meta tags for social sites and search engines-->
<meta property="og:locale" content="vi_VN" />
<meta property="og:type" content="website" />
<meta property="og:title" content="NinhHoaRaoVat - <?= esc($row['name']) ?>" />
<meta property="og:keywords" content="NinhHoaRaoVat - <?= esc($row['meta_keyword']) ?>">
<meta property="og:description" content="NinhHoaRaoVat - <?= esc($row['meta_description']) ?>" />
<meta property="og:url" content="<?= current_url(); ?>" />
<meta property="og:image" content="<?= base_url(PATH_POST_MEDIUM_IMAGE . $gallery[0]) ?>" />
<meta property="og:image:secure_url" content="<?= base_url(PATH_POST_MEDIUM_IMAGE . $gallery[0]) ?>" />
<meta property="og:image:width" content="650" />
<meta property="og:image:height" content="450" />
<!--twitter description-->
<meta name="twitter:description" content="NinhHoaRaoVat - <?= esc($row['meta_description']) ?>" />
<meta name="twitter:title" content="NinhHoaRaoVat - <?= esc($row['name']) ?>" />
<meta name="twitter:keywords" content="NinhHoaRaoVat - <?= esc($row['meta_keyword']) ?>" />
<meta name="twitter:image" content="<?= base_url(PATH_POST_MEDIUM_IMAGE . $gallery[0]) ?>" />
<?= $this->endSection() ?>
<!-- end metaSeo -->

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/extensions/swiper.min.css') ?>
<?= link_tag('app-assets/vendors/css/fancybox/jquery.fancybox.min.css') ?>
<?= link_tag('app-assets/css/plugins/forms/form-validation.min.css') ?>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/pages/page-blog.min.css') ?>
<?= link_tag('app-assets/css/plugins/extensions/ext-component-swiper.min.css') ?>
<?= link_tag('app-assets/vendors/css/extensions/sweetalert2.min.css') ?>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/extensions/swiper.min.js') ?>
<?= script_tag('app-assets/vendors/js/fancybox/jquery.fancybox.min.js') ?>
<?= script_tag('app-assets/vendors/js/forms/validation/jquery.validate.min.js') ?>
<?= script_tag('app-assets/vendors/js/extensions/sweetalert2.all.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<script>
    var url_favorites_item = "<?= route_to('user.favorites.index') ?>";

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

    $(function() {
        'use strict';

        var commentForm = $('#comment-form');

        if (commentForm.length) {
            commentForm.validate({
                rules: {
                    body: {
                        required: true,
                    },
                },
                messages: {
                    body: {
                        required: "Nội dung bình luận không được bỏ trống.",
                    },
                },
            });
        }

        $(commentForm).on('submit', function(event) {
            event.preventDefault();
            var body = $('#body').val();
            var post_id = $('input[name=post_id]').val();
            var comment_id = $('input[name=comment_id]').val();

            $.ajax({
                url: "<?= route_to('user.comment.postComment') ?>",
                method: "POST",
                async: false,
                cache: false,
                data: {
                    body: body,
                    post_id: post_id,
                    comment_id: comment_id
                },
                dataType: "JSON",
                success: function(response) {
                    if (!response.error) {
                        $(commentForm)[0].reset();
                        $('#message').html(response.message);
                        $('input[name=comment_id]').val();
                        showComments();

                        if (feather) {
                            feather.replace({
                                width: 14,
                                height: 14
                            });
                        }
                    } else if (response.error) {
                        $('#message').html(response.message);
                    }
                },
                complete: function() {
                    $('input[name=comment_id]').val('');
                    $('#reply-body').html('');
                }
            })
        });

        showComments();

        function showComments() {
            var post_id = $('input[name=post_id]').val();

            $.ajax({
                url: "<?= route_to('user.comment.showComments') ?>",
                method: "POST",
                async: false,
                cache: false,
                data: {
                    post_id: post_id,
                },
                dataType: "JSON",
                success: function(data) {
                    $('#show-comment').html(data.html);

                    var increment = 10;
                    var startFilter = 0;
                    var endFilter = increment;
                    var $this = $('.media');
                    var elementLength = $this.length;

                    if (elementLength > 9) {
                        $('#comment-loadmore').show();
                    }

                    $('#show-comment .media').slice(startFilter, endFilter).addClass('shown');
                    $('#show-comment .media').not('.shown').hide();
                    $('#comment-loadmore').on('click', function() {
                        if (elementLength > endFilter) {
                            startFilter += increment;
                            endFilter += increment;
                            $('#show-comment .media').slice(startFilter, endFilter).not('.shown').addClass('shown').toggle(500);
                            if (elementLength <= endFilter) {
                                $(this).remove();
                            }
                        }

                    });
                }
            })
        }

        $(document).on('click', '.reply', function() {
            var comment_id = $(this).attr("id");
            var comment_body = $(this).data("body");
            $('input[name=comment_id]').val(comment_id);
            $('textarea[name=body]').focus();
            $('#message').html('');
            $('#reply-body').text('Trả Lời Bình Luận: ' + comment_body);
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
                                    <ol class="breadcrumb d-flex">
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

                    <a href="javascript:void(0)" class="btn btn-outline-secondary btn-wishlist me-0 me-sm-1 mb-1 mb-sm-0" data-favorites="<?= checkFavorites() ?>" data-id="<?= esc($row['postId']) ?>">
                        <i data-feather="heart" class="me-50"></i>
                        <span>Lưu Tin</span>
                    </a>

                    <hr class="my-2" />
                    <div class="media">
                        <div class="avatar mr-2">
                            <?= img(userShowImage($row['avatar']), false, ['width' => 60, 'height' => 60, 'alt' => esc($row['fullname'])]) ?>
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

        <div class="col-12 mt-1" id="blogComment">
            <h6 class="section-label mt-25">Bình luận về bài đăng</h6>
            <div class="card">
                <div class="card-body">
                    <div id="show-comment"></div>
                    <button type="button" style="display: none;" id="comment-loadmore" class="load-more btn btn-primary btn-block">Xem Thêm</button>
                </div>
            </div>
        </div>

        <div class="col-12 mt-1">
            <h6 class="section-label mt-25">Để lại bình luận</h6>
            <div class="card">
                <div class="card-body">
                    <?php if (logged_in()) : ?>
                        <?= form_open('', ['id' => 'comment-form', 'class' => 'form']) ?>
                        <?= form_hidden('post_id', $row['postId']) ?>
                        <?= form_hidden('comment_id', 0) ?>

                        <div class="mb-1">
                            <span id="message"></span>
                            <span id="reply-body" class="text-primary"></span>
                        </div>

                        <div class="row">
                            <div class="col-sm-6 col-12">
                                <div class="form-group mb-2">
                                    <?= form_label('Họ và tên', 'fullname', ['class' => 'form-label text-capitalize']) ?>
                                    <?= form_input('fullname', user()->fullname, ['class' => 'form-control text-capitalize', 'id' => 'fullname', 'disabled' => 'disabled']) ?>
                                </div>
                            </div>
                            <div class="col-sm-6 col-12">
                                <div class="form-group mb-2">
                                    <?= form_label('E-mail', 'email', ['class' => 'form-label text-capitalize']) ?>
                                    <?= form_input('email', user()->email, ['class' => 'form-control', 'id' => 'email', 'disabled' => 'disabled']) ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <?= form_label('Nội dung', 'body', ['class' => 'form-label text-capitalize']) ?>
                                    <?= form_textarea('body', '', ['class' => 'form-control mb-2', 'rows' => 4, 'id' => 'body']) ?>
                                </div>
                            </div>
                            <div class="col-12">
                                <?= form_submit(NULL, 'Đăng Bình Luận', ['class' => 'btn btn-primary']) ?>
                            </div>
                        </div>
                        <?= form_close() ?>
                    <?php else : ?>
                        <?= form_open('', ['id' => 'comment-form', 'class' => 'form']) ?>
                        <?= form_hidden('post_id', $row['postId']) ?>
                        <p class="text-danger m-0 text-center">Bạn cần đăng nhập để có thể đăng bình luận cá nhân.</p>
                        <?= form_close() ?>
                    <?php endif; ?>
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
        <?php if (count($getCategoryList) > 0) : ?>
            <div class="blog-sidebar mb-2 my-lg-0">
                <div class="blog-categories">
                    <h6 class="section-label">Danh Mục</h6>
                    <div class="mt-1">
                        <?php foreach ($getCategoryList as $item) : ?>
                            <div class="d-flex justify-content-start align-items-center mb-75">
                                <a href="<?= route_to('user.category.category', $item['slug'], $item['id']) ?>" class="mr-75">
                                    <div class="avatar bg-light-primary rounded">
                                        <div class="avatar-content">
                                            <?= img(categoryShowImage($item['image']), false, ['width' => 32, 'height' => 32]) ?>
                                        </div>
                                    </div>
                                </a>
                                <a href="<?= route_to('user.category.category', $item['slug'], $item['id']) ?>" data-toggle="tooltip" data-placement="bottom" title="<?= esc($item['name']) ?>">
                                    <div class="blog-category-title text-body text-capitalize"><?= esc($item['name']) ?></div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <?php if (count($getProductRelated) > 0) : ?>
                <div class="blog-recent-posts mt-3">
                    <h6 class="section-label">Bài đăng liên quan</h6>
                    <div class="mt-75">
                        <?php foreach ($getProductRelated as $item) : ?>
                            <?php $img = explode(',', $item['thumb_list']); ?>
                            <div class="media mb-2">
                                <a href="<?= route_to('user.post.detail', esc($item['catSlug']), esc($item['slug']), esc($item['id'])) ?>" class="mr-2">
                                    <?php if (!empty($img[0])) : ?>
                                        <?= img(PATH_POST_SMALL_IMAGE . $img[0], false, ['class' => 'rounded', 'width' => 100, 'height' => 70, 'alt' => esc($item['name'])]) ?>
                                    <?php else : ?>
                                        <?= img(PATH_POST_IMAGE_DEFAULT, false, ['class' => 'rounded', 'width' => 100, 'height' => 70, 'alt' => esc($item['name'])]) ?>
                                    <?php endif; ?>
                                </a>
                                <div class="media-body">
                                    <h6 class="blog-recent-post-title">
                                        <a href="<?= route_to('user.post.detail', esc($item['catSlug']), esc($item['slug']), esc($item['id'])) ?>" class="text-body-heading text-capitalize blog-title-truncate" data-toggle="tooltip" data-placement="bottom" title="<?= esc($item['name']) ?>"><?= esc($item['name']) ?></a>
                                    </h6>
                                    <div class="text-muted mb-0"><?= getDateHumanize(esc($item['created_at'])) ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
            </div>
    </div>
</div>
<?= $this->endSection(); ?>
<!-- end Content-body -->r