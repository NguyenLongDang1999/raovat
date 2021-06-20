<?= $this->extend('templates/frontend/master'); ?>

<?= $this->section('title'); ?>
<?= esc($row['name']) ?>
<?= $this->endSection(); ?>

<!-- metaSeo -->
<?= $this->section('metaSeo') ?>
<?= csrf_meta() ?>
<meta name="title" content="NinhHoaRaoVat - <?= esc($row['name']) . ' - ' . esc($row['description']) ?>">
<meta name="keywords" content="NinhHoaRaoVat - <?= esc($row['meta_keyword']) ?>">
<meta name="description" content="NinhHoaRaoVat - <?= esc($row['meta_description']) ?>">
<meta property="og:url" content="<?= base_url(''); ?>" />
<meta name="title" content="NinhHoaRaoVat - <?= esc($row['name']) . ' - ' . esc($row['description']) ?>">
<meta name="keywords" content="NinhHoaRaoVat - <?= esc($row['meta_keyword']) ?>">
<meta name="description" content="NinhHoaRaoVat - <?= esc($row['meta_description']) ?>">
<meta property="og:image" content="<?= base_url('app-assets/images/logo.png'); ?>" />
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
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/extensions/swiper.min.js') ?>
<?= script_tag('app-assets/vendors/js/fancybox/jquery.fancybox.min.js') ?>
<?= script_tag('app-assets/vendors/js/forms/validation/jquery.validate.min.js') ?>
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
                data: {
                    body: body,
                    post_id: post_id,
                    comment_id: comment_id,
                },
                dataType: "JSON",
                success: function(response) {
                    if (!response.error) {
                        $(commentForm)[0].reset();
                        $('#message').html(response.message);
                        $('input[name=comment_id]').val();
                        showComments();
                    } else if (response.error) {
                        $('#message').html(response.message);
                    }
                }
            })
        });

        showComments();

        function showComments() {
            var post_id = $('input[name=post_id]').val();
            var comment_id = $('input[name=comment_id]').val();

            $.ajax({
                url: "<?= route_to('user.comment.showComments') ?>",
                method: "POST",
                data: {
                    post_id: post_id,
                    comment_id: comment_id,
                },
                dataType: "JSON",
                success: function(data) {
                    $('#show-comment').html(data.html);
                }
            })
        }

        $(document).on('click', '.reply', function() {
            var comment_id = $(this).attr("id");
            var comment_body = $(this).data("body");
            $('input[name=comment_id]').val(comment_id);
            $('textarea[name=body]').focus();
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

        <div class="col-12 mt-1">
            <h6 class="section-label mt-25">Để lại bình luận</h6>
            <div class="card">
                <div class="card-body">
                    <?php if (logged_in()) : ?>
                        <?= form_open('', ['id' => 'comment-form', 'class' => 'form']) ?>
                        <?= form_hidden('post_id', $row['postId']) ?>
                        <?= form_hidden('comment_id', 0) ?>
                        <span id="message"></span>
                        <span id="reply-body" class="text-primary"></span>

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
                        <p class="text-danger m-0 text-center">Bạn cần đăng nhập để có thể đăng bình luận cá nhân.</p>
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