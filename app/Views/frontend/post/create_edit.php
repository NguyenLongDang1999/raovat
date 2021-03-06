<?= $this->extend('templates/frontend/master'); ?>

<?= $this->section('title'); ?>
<?= !isset($row) ? 'Đăng tin rao vặt' : 'Cập nhật tin rao vặt' ?>
<?= $this->endSection(); ?>

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/forms/select/select2.min.css') ?>
<?= link_tag('app-assets/vendors/css/editors/quill/quill.snow.css') ?>
<?= link_tag('app-assets/vendors/css/image-uploader/image-uploader.min.css') ?>
<?= link_tag('app-assets/vendors/css/pickers/daterange/daterangepicker.css') ?>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/plugins/forms/form-quill-editor.min.css') ?>
<?= link_tag('app-assets/css/pages/page-blog.min.css') ?>
<?= link_tag('app-assets/css/plugins/forms/form-validation.css') ?>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/forms/select/select2.full.min.js') ?>
<?= script_tag('app-assets/vendors/js/forms/cleave/cleave.min.js') ?>
<?= script_tag('app-assets/vendors/js/editors/quill/quill.min.js') ?>
<?= script_tag('app-assets/vendors/js/image-uploader/image-uploader.min.js') ?>
<?= script_tag('app-assets/vendors/js/forms/validation/jquery.validate.min.js') ?>
<?= script_tag('app-assets/vendors/js/extensions/moment.min.js') ?>
<?= script_tag('app-assets/vendors/js/pickers/daterange/daterangepicker.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<?= $this->include('frontend/post/scripts') ?>
<?php if (isset($row)) : ?>
    <script>
        let preloaded = [
            <?php $thumb_list = explode(',', $row['thumb_list']); ?>
            <?php $no = 1; ?>
            <?php if (!empty($thumb_list[0])) : ?>
                <?php foreach ($thumb_list as $img) { ?> {
                        id: <?= $no++ ?>,
                        src: '<?= base_url(PATH_POST_MEDIUM_IMAGE . $img) ?>'
                    },
                <?php } ?>
            <?php endif; ?>
        ];
        var district_id = "<?= $row['district_id'] ?>";
        var district_name = "<?= $row['districtName'] ?>";
        $('.input-images-2').imageUploader({
            preloaded: preloaded,
            imagesInputName: 'photos',
            preloadedInputName: 'old',
            maxFiles: 5,
            maxSize: 10 * 1024 * 1024,
            extensions: [".jpg", ".jpeg", ".png", ".gif"],
        });
        var $option = $("<option selected></option>").val(district_id).text(district_name);
        $('#district_id').append($option).trigger('change');
    </script>
<?php endif; ?>
<?= $this->endSection() ?>
<!-- end pageJS -->

<!-- Content-header -->
<?= $this->section('content-header'); ?>
<div class="content-header-left col-12">
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
                                        <?php if (!isset($row)) : ?>
                                            <li class="breadcrumb-item active" aria-current="page">Đăng Tin Rao Vặt</li>
                                        <?php else : ?>
                                            <li class="breadcrumb-item">
                                                <a href="<?= route_to('user.user.manager') ?>">
                                                    Quản Lý Tin Đăng
                                                </a>
                                            </li>
                                            <li class="breadcrumb-item active" aria-current="page">Cập Nhật</li>
                                        <?php endif; ?>
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
<div class="blog-edit-wrapper">
    <div class="row">
        <div class="col-12">
            <?php if (isset($row)) : ?>
                <?= form_open_multipart(route_to('user.manager.update', $row['id']), ['id' => 'post-form']) ?>
            <?php else : ?>
                <?= form_open_multipart(route_to('user.post.postPost'), ['id' => 'post-form']) ?>
            <?php endif; ?>
            <input type="hidden" id="quill_html" name="description" />
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-capitalize">Thông tin cơ bản</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mb-2">
                                <?= form_label('Tiêu Đề', 'name') ?>
                                <?= form_input('name', isset($row) ? $row['postName'] : '', ['class' => 'form-control', 'id' => 'name']) ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mb-2">
                                <?= form_label('Danh mục', 'cat_id', ['class' => 'form-label']) ?>
                                <?= form_dropdown('cat_id', $category, isset($row['cat_id']) ? $row['cat_id'] : '', ['class' => 'form-control select2', 'id' => 'cat_id']) ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mb-2">
                                <?= form_label('Hình Thức', 'is_type', ['class' => 'form-label']) ?>
                                <?= form_dropdown('is_type', getOptionIsType(), isset($row['is_type']) ? $row['is_type'] : '', ['class' => 'form-control select2', 'id' => 'is_type']) ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mb-2">
                                <?= form_label('Giá ', 'price', ['class' => 'form-label']) ?>
                                <?= form_input('price', isset($row['price']) && $row['price'] != 0 ? $row['price'] : '0', ['class' => 'form-control numeral-mask', 'id' => 'price', 'placeholder' => '10,000']) ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <?= form_label('Tỉnh/Thành Phố', 'province_id', ['class' => 'form-label']) ?>
                                <?= form_dropdown('province_id', $province, isset($row['province_id']) ? $row['province_id'] : '', ['class' => 'form-control select2', 'id' => 'province_id']) ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group">
                                <?= form_label('Quận/Huyện', 'district_id', ['class' => 'form-label']) ?>
                                <?= form_dropdown('district_id', [], isset($row['district_id']) ? $row['district_id'] : '', ['class' => 'form-control select2', 'id' => 'district_id']) ?>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <?= form_label('Địa Chỉ Liên Hệ', 'contact_address', ['class' => 'form-label text-capitalize']) ?>
                                <?= form_textarea('contact_address', isset($row['contact_address']) ? $row['contact_address'] : '', ['class' => 'form-control', 'id' => 'contact_address', 'rows' => 3]) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-capitalize">Mô tả chi tiết tin</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group mb-2">
                                <div id="blog-editor-wrapper">
                                    <div id="blog-editor-container">
                                        <div class="editor">
                                            <?= isset($row) ? $row['description'] : '' ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-capitalize">Hình Ảnh</h4>
                </div>
                <div class="card-body">
                    <ul>
                        <li>Hình đầu tiên sẽ là hình đại diện của tin.</li>
                        <li>Chỉ được đăng tối đa 5 ảnh với 1 tin.</li>
                        <li>Nên dùng hình ảnh liên quan nhất tới tin đăng.</li>
                    </ul>
                    <?php if (isset($row)) : ?>
                        <div class="input-images-2" style="padding-top: .5rem;"></div>
                    <?php else : ?>
                        <div class="input-images-1" style="padding-top: .5rem;"></div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-capitalize">Video</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mb-2">
                                <?= form_label('Link Youtube', 'video') ?>
                                <?= form_input('video', isset($row['video']) ? $row['video'] : '', ['class' => 'form-control', 'id' => 'video']) ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-12">
                            <div class="form-group mb-2">
                                <?= form_label('Mô Tả Video', 'video_description') ?>
                                <?= form_input('video_description', isset($row['video_description']) ? $row['video_description'] : '', ['class' => 'form-control', 'id' => 'video_description']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (!isset($row)) : ?>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title text-capitalize">Chọn gói đăng tin</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 col-12">
                                <?= form_label('Chọn gói đăng tin', 'expire', ['class' => 'form-label']) ?>
                                <div class="input-group mb-2">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1">
                                            <i data-feather='calendar'></i>
                                        </span>
                                    </div>
                                    <?= form_input('expire', '', ['class' => 'form-control buttonClass', 'placeholder' => 'Vui lòng chọn']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-capitalize">Thông tin liên hệ</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-12">
                            <div class="form-group mb-2">
                                <?= form_label('Họ Và Tên', 'fullname') ?>
                                <?= form_input('fullname', user()->fullname, ['class' => 'form-control', 'disabled' => 'disabled']) ?>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group mb-2">
                                <?= form_label('Email', 'email') ?>
                                <?= form_input('email', user()->email, ['class' => 'form-control', 'disabled' => 'disabled']) ?>
                            </div>
                        </div>

                        <div class="col-md-6 col-12">
                            <div class="form-group mb-2">
                                <?= form_label('Số Điện Thoại', 'phone') ?>
                                <?= form_input('phone', user()->phone, ['class' => 'form-control', 'disabled' => 'disabled']) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12 mt-50">
                    <?= form_submit(null, 'Hoàn Tất Đăng Tin', ['class' => 'btn btn-primary mr-1']) ?>
                </div>
            </div>
            <?= form_close() ?>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<!-- end Content-body -->