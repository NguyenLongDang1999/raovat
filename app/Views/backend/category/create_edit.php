<?= $this->extend('templates/backend/master'); ?>

<?= $this->section('title'); ?>
Category <?= isset($row) ? 'Update' : 'Create' ?>
<?= $this->endSection(); ?>

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/forms/select/select2.min.css') ?>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/plugins/forms/form-validation.css') ?>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/forms/select/select2.full.min.js') ?>
<?= script_tag('app-assets/vendors/js/forms/validation/jquery.validate.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<script>
$(function() {
    'use strict';
    var categoryForm = $('#category-form');
    if (categoryForm.length) {
        categoryForm.validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255,
                    <?php if (!isset($row)) : ?>
                    remote: {
                        url: "<?= route_to('admin.category.checkExists'); ?>",
                        type: 'post',
                        dataType: 'json',
                        async: false,
                        cache: false,
                        dataFilter: function(data) {
                            let obj = eval('(' + data + ')');
                            return obj.valid;
                        },
                    }
                    <?php endif ?>
                },
                description: {
                    maxlength: 255
                },
                parent_id: {
                    required: true
                },
                meta_keyword: {
                    maxlength: 60
                },
                meta_description: {
                    maxlength: 160
                },
            },
            messages: {
                name: {
                    required: "Tiêu đề danh mục không được bỏ trống.",
                    maxlength: "Tiêu đề danh mục không được vượt quá 255 ký tự.",
                    <?php if (!isset($row)) : ?>
                    remote: "Tiêu đề danh mục này đã tồn tại. Vui lòng kiểm tra lại."
                    <?php endif ?>
                },
                description: {
                    maxlength: "Mô tả danh mục không được vượt quá 255 ký tự."
                },
                parent_id: {
                    required: "Danh mục cha không được bỏ trống.",
                },
                meta_keyword: {
                    maxlength: "Meta Keyword (SEO) không được vượt quá 60 ký tự.",
                },
                meta_description: {
                    maxlength: "Meta Description (SEO) không được vượt quá 160 ký tự."
                }
            },

        });
    }
});
</script>
<?= $this->endSection() ?>
<!-- end pageJS -->

<!-- Content-body -->
<?= $this->section('content-body'); ?>
<section class="bs-validation">
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header border-bottom">
                    <h4 class="card-title"><?= isset($row) ? 'Cập Nhật ' . esc($row['name']) : 'Thêm Mới' ?></h4>
                </div>

                <div class="card-body mt-2">
                    <?php if (isset($row)) : ?>
                    <?= form_open_multipart(route_to('admin.category.update', esc($row['id'])), ['id' => 'category-form']) ?>
                    <?php else : ?>
                    <?= form_open_multipart(route_to('admin.category.store'), ['id' => 'category-form']) ?>
                    <?php endif; ?>

                    <?php if (isset($row)) : ?>
                    <?= form_hidden('checkImg', isset($row['image']) ? $row['image'] : '') ?>
                    <?php endif ?>

                    <div class="form-group">
                        <?= form_label('Tiêu đề danh mục', 'name', ['class' => 'form-label text-capitalize']) ?>
                        <?= form_input('name', isset($row) ? $row['name'] : '', ['class' => 'form-control', 'id' => 'name']) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Mô tả danh mục', 'description', ['class' => 'form-label text-capitalize']) ?>
                        <?= form_input('description', isset($row) ? $row['description'] : '', ['class' => 'form-control', 'id' => 'description']) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Danh Mục Cha', 'parent_id', ['class' => 'form-label text-capitalize']) ?>
                        <?= form_dropdown('parent_id', $option, isset($row) ? $row['parent_id'] : '', ['class' => 'select2 form-control']) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Ảnh đại diện danh mục', 'image', ['class' => 'form-label text-capitalize']) ?>
                        <div class="media flex-column flex-md-row">
                            <?= img(!isset($row['image']) ? PATH_POST_IMAGE_DEFAULT : PATH_CATEGORY_IMAGE . $row['image'], false, ['class' => 'rounded mr-2 mb-1 mb-md-0', 'id' => 'blog-feature-image', 'width' => 100, 'height' => 100, 'alt' => 'Category Image']) ?>

                            <div class="media-body">
                                <div class="d-inline-block">
                                    <div class="form-group mb-0">
                                        <div class="custom-file">
                                            <?= form_upload('image', '', ['class' => 'custom-file-input', 'id' => 'blogCustomFile']) ?>
                                            <?= form_label('Chọn File', 'blogCustomFile', ['class' => 'custom-file-label text-capitalize']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= form_label('Meta Keyword (SEO)', 'meta_keyword', ['class' => 'form-label text-capitalize']) ?>
                        <?= form_textarea('meta_keyword', isset($row) ? $row['meta_keyword'] : '', ['class' => 'form-control', 'id' => 'meta_keyword', 'rows' => 3]) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Meta Description (SEO)', 'meta_description', ['class' => 'form-label text-capitalize']) ?>
                        <?= form_textarea('meta_description', isset($row) ? $row['meta_description'] : '', ['class' => 'form-control', 'id' => 'meta_description', 'rows' => 3]) ?>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?= form_submit('submit', 'Lưu', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->