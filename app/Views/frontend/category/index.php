<?= $this->extend('templates/frontend/master'); ?>

<?= $this->section('title'); ?>
Tất cả danh mục đăng tin rao vặt tại <?= base_url() ?>
<?= $this->endSection(); ?>

<!-- Content-body -->
<?= $this->section('content-body'); ?>
<div class="text-center">
    <h1 class="mt-5 text-capitalize">Tất cả danh mục đăng tin rao vặt</h1>
    <p class="mb-2 pb-75">
        <!-- All plans include 40+ advanced tools and features to boost your product. Choose the best plan to fit your needs. -->
    </p>
</div>
<section id="category-page">
    <div class="row kb-search-content-info match-height">
        <?php foreach ($getCategoryList as $item) : ?>
            <?php $categories = model('category') ?>
            <?php $getCategoryRecursive = $categories->getCategoryRecursive($item['id']); ?>
            <?php $getCategoryParent = $categories->getCategoryListParent($getCategoryRecursive); ?>
            <div class="col-md-4 col-sm-6 col-12 kb-search-content">
                <div class="card">
                    <div class="card-body">
                        <h6 class="kb-title">
                            <?= img(categoryShowImage($item['image']), false, ['alt' => esc($item['name']), 'class' => 'round', 'width' => '40', 'height' => '40']) ?>
                            <a href="<?= route_to('user.category.category', $item['slug'], $item['id']) ?>" class="text-body" data-toggle="tooltip" data-placement="bottom" title="<?= esc($item['name']) ?>">
                                <span class="text-capitalize"><?= esc($item['name']) ?></span>
                            </a>
                        </h6>

                        <div class="list-group list-group-circle mt-2">
                            <?php foreach ($getCategoryParent as $category) : ?>
                                <a href="<?= route_to('user.category.category', $category['slug'], $category['id']) ?>" class="list-group-item text-body">
                                    <span class="text-capitalize" data-toggle="tooltip" data-placement="bottom" title="<?= esc($category['name']) ?>">
                                        <?= esc($category['name']) ?>
                                    </span>
                                </a>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach ?>
    </div>
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->r