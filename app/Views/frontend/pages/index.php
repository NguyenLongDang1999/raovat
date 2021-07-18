<?= $this->extend('templates/frontend/master'); ?>

<?= $this->section('title'); ?>
<?= esc($row['name']) ?>
<?= $this->endSection(); ?>

<!-- metaSeo -->
<?= $this->section('metaSeo') ?>
<!--open graph meta tags for social sites and search engines-->
<meta property="og:locale" content="vi_VN" />
<meta property="og:type" content="website" />
<meta property="og:title" content="NinhHoaRaoVat - <?= esc($row['name']) ?>" />
<meta property="og:keywords" content="NinhHoaRaoVat - <?= esc($row['meta_keyword']) ?>">
<meta property="og:description" content="NinhHoaRaoVat - <?= esc($row['meta_description']) ?>" />
<meta property="og:url" content="<?= current_url(); ?>" />
<!--twitter description-->
<meta name="twitter:description" content="NinhHoaRaoVat - <?= esc($row['meta_description']) ?>" />
<meta name="twitter:title" content="NinhHoaRaoVat - <?= esc($row['name']) ?>" />
<meta name="twitter:keywords" content="NinhHoaRaoVat - <?= esc($row['meta_keyword']) ?>" />
<?= $this->endSection() ?>
<!-- end metaSeo -->

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
                                        <li class="breadcrumb-item text-capitalize active" aria-current="page"><?= esc($row['name']) ?></li>
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
<section class="pages-pages">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                <?= $row['description'] ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->