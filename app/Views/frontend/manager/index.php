<?= $this->extend('templates/frontend/master'); ?>

<?= $this->section('title'); ?>
Quản lý tin đăng cá nhân
<?= $this->endSection(); ?>

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') ?>
<?= link_tag('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') ?>
<?= link_tag('app-assets/vendors/css/extensions/sweetalert2.min.css') ?>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') ?>
<?= script_tag('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') ?>
<?= script_tag('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') ?>
<?= script_tag('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.min.js') ?>
<?= script_tag('app-assets/vendors/js/tables/datatable/datatables.checkboxes.min.js') ?>
<?= script_tag('app-assets/vendors/js/extensions/sweetalert2.all.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<?= $this->include('frontend/manager/scripts') ?>
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
                                        <li class="breadcrumb-item"><a href="<?= route_to('user.home.index') ?>">Trang
                                                Chủ</a></li>
                                        <li class="breadcrumb-item active" aria-current="page">Quản Lý Tin Đăng</li>
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
<section id="aligned-pills">
    <div class="row match-height">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills justify-content-center" id="tabMenu">
                        <li class="nav-item">
                            <a class="nav-link" id="manager-ready-tab" data-toggle="pill" href="#manager-ready" aria-expanded="true">
                                <i data-feather='loader'></i>
                                <span>Tin Đăng Chờ Duyệt</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" id="manager-active-tab" data-toggle="pill" href="#manager-active" aria-expanded="false">
                                <i data-feather='check-circle'></i>
                                <span>Tin Đang Đăng</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="manager-block-tab" data-toggle="pill" href="#manager-block" aria-expanded="false">
                                <i data-feather='slash'></i>
                                <span>Tin Đăng Không Được Duyệt</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="manager-expire-tab" data-toggle="pill" href="#manager-expire" aria-expanded="false">
                                <i data-feather='alert-circle'></i>
                                <span>Tin Đăng Hết Hạn</span>
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane" id="manager-ready" role="tabpanel" aria-labelledby="manager-ready-tab" aria-expanded="true">
                            <?= form_open('', ['id' => 'frmTbListReady']) ?>
                            <table id="get-manager-ready" class="table table-transparent nowrap">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Hình ảnh</th>
                                        <th>Thông tin bài đăng</th>
                                        <th>Gói đăng tin</th>
                                        <th>Loại tin</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                            </table>
                            <?= form_close() ?>
                        </div>
                        <div class="tab-pane active" id="manager-active" role="tabpanel" aria-labelledby="manager-active-tab" aria-expanded="false">
                            <div class="mb-1">
                                <button type="button" class="btn btn-warning glow confirm-text btn-status" data-status="3">
                                    Ẩn Tin
                                </button>

                                <button type="button" class="btn btn-primary glow confirm-text btn-status" data-status="1">
                                    Tiếp Tục Đăng
                                </button>
                            </div>
                            <?= form_open('', ['id' => 'frmTbList']) ?>
                            <table class="dt-advanced-search dt-responsive table table-white-space" id="get-post-list">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>Hình ảnh</th>
                                        <th>Thông tin bài đăng</th>
                                        <th>Gói đăng tin</th>
                                        <th>Loại tin</th>
                                        <th>Trạng thái</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                            </table>
                            <?= form_close() ?>
                        </div>
                        <div class="tab-pane" id="manager-block" role="tabpanel" aria-labelledby="manager-block-tab" aria-expanded="false">
                            <?= form_open('', ['id' => 'frmTbListBlock']) ?>
                            <table class="dt-advanced-search dt-responsive table table-white-space" id="get-manager-block">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Hình ảnh</th>
                                        <th>Thông tin bài đăng</th>
                                        <th>Gói đăng tin</th>
                                        <th>Loại tin</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                            </table>
                            <?= form_close() ?>
                        </div>
                        <div class="tab-pane" id="manager-expire" role="tabpanel" aria-labelledby="manager-expire-tab" aria-expanded="false">
                            <?= form_open('', ['id' => 'frmTbListExpire']) ?>
                            <table class="dt-advanced-search dt-responsive table table-white-space" id="get-manager-expire">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Hình ảnh</th>
                                        <th>Thông tin bài đăng</th>
                                        <th>Gói đăng tin</th>
                                        <th>Loại tin</th>
                                        <th>Thao tác</th>
                                    </tr>
                                </thead>
                            </table>
                            <?= form_close() ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->