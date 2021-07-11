<a class="nav-link" href="javascript:void(0);" data-toggle="dropdown">
    <i class="ficon" data-feather="heart"></i>
    <span class="badge badge-pill badge-primary badge-up cart-item-count"><?= esc(count($getListFavoritesCount)) ?></span>

</a>
<ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
    <li class="dropdown-menu-header">
        <div class="dropdown-header d-flex">
            <h4 class="notification-title mb-0 mr-auto">Bài Đăng Đã Lưu</h4>
            <div class="badge badge-pill badge-light-primary"><?= esc(count($getListFavoritesCount)) ?> items</div>
        </div>
    </li>
    <li class="scrollable-container media-list">

        <?php if (count($getListFavorites)) : ?>
            <?php foreach ($getListFavorites as $item) : ?>
                <?php $img = explode(',', $item['thumb_list']); ?>
                <div class="media align-items-center">
                    <?= img(postShowImage($img[0]), false, ['class' => 'd-block rounded mr-1', 'width' => 62, 'height' => 62, 'alt' => esc($item['name'])]) ?>
                    <div class="media-body">
                        <div class="media-heading">
                            <h6 class="cart-item-title"><a class="text-body text-capitalize" href="<?= route_to('user.post.detail', esc($item['catSlug']), esc($item['slug']), esc($item['id'])) ?>"> <?= esc($item['name']) ?> </a></h6>
                            <small class="cart-item-by text-capitalize"><?= esc($item['fullname']) ?></small>
                        </div>
                        <h5 class="cart-item-price"><?= $item['price'] != 0 ? esc(number_to_amount($item['price'], 2, 'vi_VN')) : 'Thương Lượng' ?></h5>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <span class="text-danger text-capitalize d-block py-1 text-center">Chưa có bài đăng nào đã được lưu.</span>
        <?php endif; ?>
    </li>
    <li class="dropdown-menu-footer">
        <a class="btn btn-primary btn-block" href="<?= route_to('user.user.manager') ?>#manager-save">Xem Thêm</a>
    </li>
</ul>