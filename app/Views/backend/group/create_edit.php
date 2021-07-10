<?= $this->extend('templates/backend/master'); ?>

<?= $this->section('title'); ?>
Group <?= isset($row) ? 'Update' : 'Create' ?>
<?= $this->endSection(); ?>

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/plugins/forms/form-validation.css') ?>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/forms/validation/jquery.validate.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<script>
$(function() {
    'use strict';
    var groupForm = $('#group-form');
    if (groupForm.length) {
        groupForm.validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 20,
                },
                description: {
                    maxlength: 100
                },
            },
            messages: {
                name: {
                    required: "Tên Group không được bỏ trống.",
                    maxlength: "Tên Group không được vượt quá 20 ký tự.",
                },
                description: {
                    maxlength: "Mô tả Group không được vượt quá 10 ký tự."
                },
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
                    <?= form_open(route_to('admin.group.update', esc($row['id'])), ['id' => 'group-form']) ?>
                    <?php else : ?>
                    <?= form_open(route_to('admin.group.store'), ['id' => 'group-form']) ?>
                    <?php endif; ?>

                    <div class="form-group">
                        <?= form_label('Tên Group', 'name', ['class' => 'form-label text-capitalize']) ?>
                        <?= form_input('name', isset($row) ? $row['name'] : '', ['class' => 'form-control', 'id' => 'name']) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Mô tả Group', 'description', ['class' => 'form-label text-capitalize']) ?>
                        <?= form_input('description', isset($row) ? $row['description'] : '', ['class' => 'form-control', 'id' => 'description']) ?>
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