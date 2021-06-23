<?= $this->extend('templates/frontend/master'); ?>

<?= $this->section('title'); ?>
Đặt lại mật khẩu
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

        var resetForm = $('.auth-reset-password-form');

        if (resetForm.length) {
            resetForm.validate({
                rules: {
                    token: {
                        required: true,
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 255,
                    },
                    password: {
                        required: true,
                        maxlength: 15,
                        minlength: 8,
                    },
                    confirm_password: {
                        equalTo: "#password"
                    },
                },
                messages: {
                    token: {
                        required: "Code không được bỏ trống.",
                    },
                    email: {
                        required: "Email không được bỏ trống.",
                        maxlength: "Email quá dài. Vui lòng kiểm tra lại.",
                        valid_email: "Email không đúng định dạng.",
                        remote: "Email này đã tồn tại. Vui lòng nhập email khác."
                    },
                    password: {
                        required: "Password không được bỏ trống.",
                        maxlength: "Password không được vượt quá 15 ký tự.",
                        minlength: "Password phải có tối thiểu 8 ký tự.",
                    },
                    confirm_password: {
                        equalTo: "Xác nhận Password không trùng khớp. Vui lòng kiểm tra lại"
                    }
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
                                    <ol class="breadcrumb d-flex">
                                        <li class="breadcrumb-item"><a href="<?= route_to('user.home.index') ?>">Trang Chủ</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Đặt Lại Mật Khẩu</li>
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
                <p class="card-text mb-2">Nhập mã code bạn nhận được qua E-mail vào Code.</p>

                <?= view('Myth\Auth\Views\_message_block') ?>

                <?= form_open(route_to('reset-password'), ['class' => 'auth-reset-password-form mt-2']) ?>

                <div class="form-group">
                    <?= form_label('Code', 'token', ['class' => 'form-label']) ?>
                    <?= form_input('token', '', ['class' => 'form-control', 'id' => 'token', 'placeholder' => 'Mã code nhận được qua E-mail']) ?>
                </div>

                <div class="form-group">
                    <?= form_label('E-mail', 'email', ['class' => 'form-label']) ?>
                    <?= form_input('email', '', ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'abc@gmail.com']) ?>
                </div>

                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <?= form_label('Password', 'password', ['class' => 'form-label']) ?>
                    </div>
                    <div class="input-group input-group-merge form-password-toggle">
                        <?= form_password('password', '', ['class' => 'form-control form-control-merge', 'id' => 'password']) ?>
                        <div class="input-group-append">
                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <?= form_label('Xác Nhận Password', 'confirm_password', ['class' => 'form-label']) ?>
                    </div>
                    <div class="input-group input-group-merge form-password-toggle">
                        <?= form_password('confirm_password', '', ['class' => 'form-control form-control-merge', 'id' => 'cornfirm_password']) ?>
                        <div class="input-group-append">
                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                        </div>
                    </div>
                </div>

                <?= form_button(['class' => 'btn btn-primary btn-block', 'type' => 'submit', 'content' => 'Gửi']) ?>
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