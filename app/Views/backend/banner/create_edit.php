<?= $this->extend('templates/backend/master'); ?>

<?= $this->section('title'); ?>
Banner <?= isset($row) ? 'Update' : 'Create' ?>
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
    var bannerForm = $('#banner-form');
    if (bannerForm.length) {
        bannerForm.validate({
            rules: {
                name: {
                    required: true,
                    maxlength: 255,
                },
                url: {
                    required: true,
                    url: true,
                    <?php if (!isset($row)) : ?>
                    remote: {
                        url: "<?= route_to('admin.banner.checkExists'); ?>",
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
                cat_id: {
                    required: true
                },
                orders: {
                    required: true
                },
            },
            messages: {
                name: {
                    required: "Ti??u ????? banner kh??ng ???????c b??? tr???ng.",
                    maxlength: "Ti??u ????? banner kh??ng ???????c v?????t qu?? 255 k?? t???.",
                },
                url: {
                    required: "???????ng d???n URL kh??ng ???????c b??? tr???ng.",
                    url: "???????ng d???n URL kh??ng ????ng ?????nh d???ng.",
                    <?php if (!isset($row)) : ?>
                    remote: "???????ng d???n URL n??y ???? t???n t???i. Vui l??ng ki???m tra l???i."
                    <?php endif ?>
                },
                description: {
                    maxlength: "M?? t??? banner kh??ng ???????c v?????t qu?? 255 k?? t???."
                },
                cat_id: {
                    required: "Danh m???c kh??ng ???????c b??? tr???ng.",
                },
                orders: {
                    required: "V??? tr?? kh??ng ???????c b??? tr???ng.",
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
                    <h4 class="card-title"><?= isset($row) ? 'C???p Nh???t ' . esc($row['name']) : 'Th??m M???i' ?></h4>
                </div>

                <div class="card-body mt-2">
                    <?php if (isset($row)) : ?>
                    <?= form_open_multipart(route_to('admin.banner.update', esc($row['id'])), ['id' => 'banner-form']) ?>
                    <?php else : ?>
                    <?= form_open_multipart(route_to('admin.banner.store'), ['id' => 'banner-form']) ?>
                    <?php endif; ?>

                    <?php if (isset($row)) : ?>
                    <?= form_hidden('checkImg', isset($row['image']) ? $row['image'] : '') ?>
                    <?php endif ?>

                    <div class="form-group">
                        <?= form_label('Ti??u ????? banner', 'name', ['class' => 'form-label text-capitalize']) ?>
                        <?= form_input('name', isset($row) ? $row['name'] : '', ['class' => 'form-control', 'id' => 'name']) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('???????ng d???n url', 'url', ['class' => 'form-label text-capitalize']) ?>
                        <?= form_input('url', isset($row) ? $row['url'] : '', ['class' => 'form-control', 'id' => 'url']) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('M?? t??? banner', 'description', ['class' => 'form-label text-capitalize']) ?>
                        <?= form_input('description', isset($row) ? $row['description'] : '', ['class' => 'form-control', 'id' => 'description']) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Danh M???c', 'cat_id', ['class' => 'form-label text-capitalize']) ?>
                        <?= form_dropdown('cat_id', $option, isset($row) ? $row['cat_id'] : '', ['class' => 'select2 form-control', 'id' => 'cat_id']) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('V??? Tr??', 'orders', ['class' => 'form-label']) ?>
                        <?= form_dropdown('orders', getOptionOrders(), isset($row) ? $row['orders'] : '', ['class' => 'form-control select2', 'id' => 'orders']) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('???nh ?????i di???n banner', 'image', ['class' => 'form-label text-capitalize']) ?>
                        <div class="media flex-column flex-md-row">
                            <?= img(!isset($row['image']) ? PATH_POST_IMAGE_DEFAULT : PATH_BANNER_IMAGE . $row['image'], false, ['class' => 'rounded mr-2 mb-1 mb-md-0', 'id' => 'blog-feature-image', 'width' => 300, 'height' => 300, 'alt' => 'Banner Image']) ?>
                            <div class="media-body">
                                <div class="d-inline-block">
                                    <div class="form-group mb-0">
                                        <div class="custom-file">
                                            <?= form_upload('image', '', ['class' => 'custom-file-input', 'id' => 'blogCustomFile']) ?>
                                            <?= form_label('Ch???n File', 'blogCustomFile', ['class' => 'custom-file-label text-capitalize']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?= form_submit('submit', 'L??u', ['class' => 'btn btn-primary']) ?>
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