<?php $pager->setSurroundCount(2) ?>

<?php if (count($pager->links()) > 1) { ?>
    <nav>
        <ul class="pagination justify-content-center mt-2">
            <?php if ($pager->getPreviousPage()) : ?>
                <li class="page-item prev-item"><a class="page-link" href="<?= $pager->getPreviousPage() ?>"></a></li>
            <?php endif ?>

            <?php foreach ($pager->links() as $link) : ?>
                <li class="page-item <?= $link['active'] ? 'active' : '' ?>" aria-current="page"><a class="page-link" href="<?= $link['uri'] ?>"><?= $link['title'] ?></a></li>
            <?php endforeach ?>

            <?php if ($pager->getNextPage()) : ?>
                <li class="page-item next-item"><a class="page-link" href="<?= $pager->getNextPage() ?>"></a></li>
            <?php endif ?>
        </ul>
    </nav>
<?php } ?>