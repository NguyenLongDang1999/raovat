<!DOCTYPE html>
<html class="loading" lang="vi" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="robots" content="index, follow" />
    <?= $this->renderSection('metaSeo') ?>
    <?= csrf_meta() ?>
    <title>NinhHoaRaoVat - <?= $this->renderSection('title') ?></title>
    <?= $this->include('templates/frontend/linkCSS') ?>
</head>

<body class="horizontal-layout horizontal-menu content-detached-left-sidebar navbar-floating footer-static  "
    data-open="hover" data-menu="horizontal-menu" data-col="content-detached-left-sidebar">

    <?= $this->include('templates/frontend/header') ?>

    <?= $this->include('templates/frontend/menu') ?>

    <div class="app-content content <?= (isset($is_category_page) && $is_category_page || isset($is_home_page) && $is_home_page) ? 'ecommerce-application' : '' ?>">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <?= $this->renderSection('content-header') ?>
            </div>
            <?php if (isset($is_category_page) && $is_category_page) : ?>
            <div class="content-detached content-right">
                <?php endif ?>
                <div class="content-body <?= (isset($is_category_page) && $is_category_page && isset($countPost) && $countPost == 0) ? 'ml-0' : '' ?>">
                    <?= $this->renderSection('content-body') ?>
                </div>
            </div>
        </div>

        <div class="sidenav-overlay"></div>
        <div class="drag-target"></div>

        <button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>

        <?= $this->include('templates/frontend/linkJS') ?>
</body>

</html>