<!DOCTYPE html>
<html class="loading" lang="vi" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <title>NinhHoaRaoVat - Login Administrator</title>
    <link rel="apple-touch-icon" href="<?= base_url() ?>/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= base_url() ?>/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">
    <?= link_tag('app-assets/vendors/css/vendors.min.css') ?>
    <?= link_tag('app-assets/css/bootstrap.min.css') ?>
    <?= link_tag('app-assets/css/bootstrap-extended.min.css') ?>
    <?= link_tag('app-assets/css/colors.min.css') ?>
    <?= link_tag('app-assets/css/components.min.css') ?>
    <?= link_tag('app-assets/css/themes/bordered-layout.min.css') ?>
    <?= link_tag('app-assets/css/plugins/forms/form-validation.css') ?>
    <?= link_tag('app-assets/css/pages/page-auth.min.css') ?>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu blank-page navbar-floating footer-static  " data-open="hover" data-menu="horizontal-menu" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-v1 px-2">
                    <div class="auth-inner py-2">
                        <div class="card mb-0">
                            <div class="card-body">
                                <h4 class="card-title mb-1">Welcome to NinhHoaRaoVat! 👋</h4>

                                <?= view('Myth\Auth\Views\_message_block') ?>

                                <?= form_open(route_to('login'), ['class' => 'auth-login-form mt-2']) ?>
                                <div class="form-group">
                                    <?= form_label('E-mail', 'login', ['class' => 'form-label']) ?>
                                    <?= form_input('login', '', ['class' => 'form-control', 'placeholder' => 'abc@gmail.com', 'id' => 'login']) ?>
                                </div>

                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <?= form_label('Password', 'password', ['class' => 'form-label']) ?>
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
                                <?= form_submit('submit', 'Đăng Nhập', ['class' => 'btn btn-primary btn-block']) ?>
                                <?= form_close() ?>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Content-->

    <?= script_tag('app-assets/vendors/js/vendors.min.js') ?>
    <?= script_tag('app-assets/vendors/js/ui/jquery.sticky.js') ?>
    <?= script_tag('app-assets/vendors/js/forms/validation/jquery.validate.min.js') ?>
    <?= script_tag('app-assets/js/core/app-menu.min.js') ?>
    <?= script_tag('app-assets/js/core/app.min.js') ?>
    <?= script_tag('app-assets/js/scripts/pages/page-auth-login.js') ?>
    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        })
    </script>
</body>
<!-- END: Body-->

</html>