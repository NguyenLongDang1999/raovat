<?= $this->extend('templates/frontend/master'); ?>

<?= $this->section('title'); ?>
Đăng ký tài khoản thành viên đăng tin tại <?= base_url() ?>
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

    var registerForm = $('.auth-register-form');

    jQuery.validator.addMethod('valid_phone', function(value) {
        var regex =
            /^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/;
        return value.trim().match(regex);
    });

    if (registerForm.length) {
        registerForm.validate({
            rules: {
                fullname: {
                    required: true,
                    maxlength: 30,
                },
                phone: {
                    required: true,
                    valid_phone: true
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 255,
                    remote: {
                        url: "<?= route_to('user.auth.checkEmail'); ?>",
                        type: 'post',
                        dataType: 'json',
                        async: false,
                        cache: false,
                        dataFilter: function(data) {
                            let obj = eval('(' + data + ')');
                            return obj.valid;
                        },
                    }
                },
                password: {
                    required: true,
                    minlength: 8,
                    maxlength: 20
                },
                confirm_password: {
                    equalTo: "#password"
                },
            },
            messages: {
                fullname: {
                    required: "Họ và tên không được bỏ trống.",
                    maxlength: "Họ và tên không được vượt quá 30 ký tự.",
                },
                phone: {
                    required: "Số điện thoại không được bỏ trống.",
                    valid_phone: "Số điện thoại không hợp lệ.",
                },
                email: {
                    required: "Email không được bỏ trống.",
                    maxlength: "Email quá dài. Vui lòng kiểm tra lại.",
                    valid_email: "Email không đúng định dạng.",
                    remote: "Email này đã tồn tại. Vui lòng nhập email khác."
                },
                password: {
                    required: "Password không được bỏ trống.",
                    minlength: "Password nên có độ dài từ 8 đến 20 ký tự.",
                    maxlength: "Password nên có độ dài từ 8 đến 20 ký tự."
                },
                confirm_password: {
                    equalTo: "Xác nhận Password không trùng khớp. Vui lòng kiểm tra lại."
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
                                        <li class="breadcrumb-item active" aria-current="page">Đăng Ký</li>
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
                <h4 class="card-title mb-1">Đăng Ký</h4>

                <?= view('Myth\Auth\Views\_message_block') ?>

                <?= form_open(route_to('register'), ['class' => 'auth-register-form mt-2']) ?>
                <div class="form-group">
                    <?= form_label('Họ và tên', 'fullname', ['class' => 'form-label text-capitalize']) ?>
                    <?= form_input('fullname', '', ['class' => 'form-control', 'id' => 'fullname', 'placeholder' => 'Nguyễn Văn A']) ?>
                </div>

                <div class="form-group">
                    <?= form_label('Số điện thoại', 'phone', ['class' => 'form-label']) ?>
                    <?= form_input('phone', '', ['class' => 'form-control', 'id' => 'phone', 'placeholder' => '']) ?>
                </div>

                <div class="form-group">
                    <?= form_label('Email', 'email', ['class' => 'form-label']) ?>
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

                <div class="form-group">
                    <?= form_label('Giới tính', '', ['class' => 'd-block text-capitalize']) ?>
                    <div class="custom-control custom-radio my-50">
                        <?= form_radio('gender', '1', true, ['class' => 'custom-control-input', 'id' => 'male']) ?>
                        <?= form_label('Nam', 'male', ['class' => 'custom-control-label']) ?>
                    </div>
                    <div class="custom-control custom-radio">
                        <?= form_radio('gender', '0', false, ['class' => 'custom-control-input', 'id' => 'female']) ?>
                        <?= form_label('Nữ', 'female', ['class' => 'custom-control-label']) ?>
                    </div>
                </div>
                <?= form_button(['class' => 'btn btn-primary btn-block', 'type' => 'submit', 'content' => 'Đăng Ký']) ?>
                <?= form_close() ?>

                <p class="text-center mt-2">
                    <span>Nếu bạn đã có tài khoản?</span>
                    <a href="<?= route_to('login') ?>">
                        <span>Đăng Nhập</span>
                    </a>
                </p>

                <div class="divider my-2">
                    <div class="divider-text">Hoặc</div>
                </div>

                <div class="auth-footer-btn d-flex justify-content-center">
                    <a href="<?= route_to('user.user.socialLogin') ?>?provider=facebook" class="btn btn-facebook">
                        <i data-feather="facebook"></i>
                    </a>
                    <a href="javascript:void(0)" class="btn btn-twitter white">
                        <i data-feather="twitter"></i>
                    </a>
                    <a href="<?= route_to('user.user.socialLogin') ?>?provider=google" class="btn btn-google">
                        <i data-feather="mail"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection(); ?>
<!-- end Content-body -->