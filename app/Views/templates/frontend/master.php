<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="robots" content="index, follow" />
    <?= csrf_meta() ?>
    <title>NinhHoaRaoVat - <?= $this->renderSection('title') ?></title>
    <?= $this->include('templates/frontend/linkCSS') ?>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="horizontal-layout horizontal-menu content-detached-left-sidebar navbar-floating footer-static  "
    data-open="hover" data-menu="horizontal-menu" data-col="content-detached-left-sidebar">

    <!-- BEGIN: Header-->
    <?= $this->include('templates/frontend/header') ?>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <?= $this->include('templates/frontend/menu') ?>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content <?= (isset($is_category_page) && $is_category_page) ? 'ecommerce-application' : '' ?>">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <?= $this->renderSection('content-header') ?>
            </div>
            <?php if (isset($is_category_page) && $is_category_page) : ?>
            <div class="content-detached content-right">
                <?php endif ?>
                <div class="content-body">
                    <?= $this->renderSection('content-body') ?>
                </div>
            </div>
        </div>
        <!-- END: Content-->

        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        <!-- BEGIN: Footer-->
        <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
        <!-- END: Footer-->

        <?= $this->include('templates/frontend/linkJS') ?>
</body>
<!-- END: Body-->

</html>