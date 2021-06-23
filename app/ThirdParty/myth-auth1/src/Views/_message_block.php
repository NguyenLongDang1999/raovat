<?php if (session()->has('message')) : ?>
<div class="demo-spacing-0">
    <div class="alert alert-primary mb-2" role="alert">
        <div class="alert-body">
            <i data-feather="star"></i>
            <span> <?= session('message') ?> </span>
        </div>
    </div>
</div>
<?php endif ?>

<?php if (session()->has('error')) : ?>
<div class="demo-spacing-0">
    <div class="alert alert-danger mt-1 alert-validation-msg mb-2" role="alert">
        <div class="alert-body">
            <i data-feather="info" class="mr-50 align-middle"></i>
            <?= session('error') ?>
        </div>
    </div>
</div>
<?php endif ?>