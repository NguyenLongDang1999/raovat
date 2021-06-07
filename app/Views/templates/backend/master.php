<!DOCTYPE html>
<html class="loading bordered-layout" lang="vi" data-layout="bordered-layout" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <?= csrf_meta() ?>
    <title>NinhHoaRaoVat - <?= $this->renderSection('title') ?></title>

    <?= $this->include('templates/backend/linkCSS') ?>
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

    <!-- BEGIN: Header-->
    <?= $this->include('templates/backend/header') ?>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <?= $this->include('templates/backend/menu') ?>
    <!-- END: Main Menu-->

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
                <?= $this->renderSection('content-header') ?>
            </div>
            <div class="content-body">
                <!-- Dashboard Ecommerce Starts -->
                <?= $this->renderSection('content-body') ?>
                <!-- Dashboard Ecommerce ends -->
            </div>
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    <?= $this->include('templates/backend/linkJS') ?>
</body>
<!-- END: Body-->

</html>