<?= $this->extend('templates/frontend/master'); ?>

<?= $this->section('title'); ?>
Quên mật khẩu
<?= $this->endSection(); ?>

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/pages/page-auth.min.css') ?>
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

        var forgotForm = $('.auth-forgot-password-form');

        if (forgotForm.length) {
            forgotForm.validate({
                rules: {
                    email: {
                        required: true,
                        email: true,
                        maxlength: 255,
                    },
                },
                messages: {
                    email: {
                        required: "Email không được bỏ trống.",
                        maxlength: "Email quá dài. Vui lòng kiểm tra lại.",
                        valid_email: "Email không đúng định dạng.",
                        remote: "Email này đã tồn tại. Vui lòng nhập email khác."
                    },
                }
            });
        }
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
                                        <li class="breadcrumb-item"><a href="<?= route_to('user.home.index') ?>">Trang Chủ</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Quên Mật Khẩu</li>
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
<div class="auth-wrapper auth-v1 px-2">
    <div class="auth-inner pb-2">
        <div class="card mb-0">
            <div class="card-body">
                <h4 class="card-title mb-1">Quên Mật Khẩu? 🔒</h4>
                <p class="card-text mb-2">Nhập E-mail của bạn và chúng tôi sẽ gửi hướng dẫn để đặt lại mật khẩu của bạn.</p>

                <?= view('Myth\Auth\Views\_message_block') ?>

                <?= form_open(route_to('forgot'), ['class' => 'auth-forgot-password-form mt-2']) ?>
                <div class="form-group">
                    <?= form_label('E-mail', 'email', ['class' => 'form-label']) ?>
                    <?= form_input('email', '', ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'abc@gmail.com']) ?>
                </div>
                <?= form_submit(null, 'Gửi', ['class' => 'btn btn-primary btn-block']) ?>
                <?= form_close() ?>

                <p class="text-center mt-2">
                    <a href="<?= route_to('login') ?>"> <i data-feather="chevron-left"></i> Trở Lại Trang Đăng Nhập </a>
                </p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<!-- end Content-body -->