<?= $this->extend('templates/frontend/master'); ?>

<?= $this->section('title'); ?>
Đăng nhập vào hệ thống rao vặt <?= base_url() ?>
<?= $this->endSection(); ?>

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/pages/page-auth.min.css') ?>
<?= link_tag('app-assets/css/plugins/forms/form-validation.min.css') ?>
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

        var loginForm = $('.auth-login-form');

        if (loginForm.length) {
            loginForm.validate({
                rules: {
                    login: {
                        required: true,
                        email: true
                    },
                    password: {
                        required: true,
                        minlength: 8,
                        maxlength: 20
                    }
                },
                messages: {
                    login: {
                        required: "Email không được bỏ trống.",
                        email: "Email không đúng định dạng."
                    },
                    password: {
                        required: "Password không được bỏ trống.",
                        minlength: "Password nên có độ dài từ 8 đến 20 ký tự.",
                        maxlength: "Password nên có độ dài từ 8 đến 20 ký tự."
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
                                    <ol class="breadcrumb">
                                        <li class="breadcrumb-item"><a href="<?= route_to('user.home.index') ?>">Trang
                                                Chủ</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Đăng Nhập</li>
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
                <h4 class="card-title mb-1">Đăng Nhập</h4>

                <?= view('Myth\Auth\Views\_message_block') ?>

                <?= form_open(route_to('login'), ['class' => 'auth-login-form mt-2']) ?>
                <div class="form-group">
                    <?= form_label('E-mail', 'login', ['class' => 'form-label']) ?>
                    <?= form_input('login', '', ['class' => 'form-control', 'placeholder' => 'abc@gmail.com', 'id' => 'login']) ?>
                </div>

                <div class="form-group">
                    <div class="d-flex justify-content-between">
                        <?= form_label('Password', 'password', ['class' => 'form-label']) ?>
                        <a href="<?= route_to('forgot') ?>">
                            <small>Quên Mật Khẩu?</small>
                        </a>
                    </div>
                    <div class="input-group input-group-merge form-password-toggle">
                        <?= form_password('password', '', ['class' => 'form-control form-control-merge', 'placeholder' => '****************;', 'id' => 'password']) ?>
                        <div class="input-group-append">
                            <span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                        <input class="custom-control-input" type="checkbox" name="remember" id="remember">
                        <label class="custom-control-label" for="remember">Nhớ Mật Khẩu</label>
                    </div>
                </div>
                <?= form_button(['class' => 'btn btn-primary btn-block', 'type' => 'submit', 'content' => 'Đăng Nhập']) ?>
                <?= form_close() ?>

                <p class="text-center mt-2">
                    <span>Nếu bạn chưa có tài khoản?</span>
                    <a href="<?= route_to('register') ?>">
                        <span>Đăng Ký</span>
                    </a>
                </p>

                <div class="divider my-2">
                    <div class="divider-text">Hoặc</div>
                </div>

                <div class="auth-footer-btn d-flex justify-content-center">
                    <a href="javascript:void(0)" class="btn btn-facebook">
                        <i data-feather="facebook"></i>
                    </a>
                    <a href="javascript:void(0)" class="btn btn-twitter white">
                        <i data-feather="twitter"></i>
                    </a>
                    <a href="<?= route_to('user.user.socialLoginGoogle') ?>" class="btn btn-google">
                        <i data-feather="mail"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<!-- end Content-body -->