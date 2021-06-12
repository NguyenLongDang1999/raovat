<?= form_open(route_to('user.auth.changeEmail'), ['id' => 'email-form']); ?>
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <?= form_label('Nhập E-mail mới', 'email', ['class' => 'form-label']) ?>
            <?= form_input('email', '', ['class' => 'form-control', 'id' => 'email', 'placeholder' => 'abc@gmail.com']) ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="form-group">
            <?= form_label('Mật Khẩu Cũ', 'password', ['class' => 'form-label']) ?>
            <div class="input-group form-password-toggle input-group-merge">
                <?= form_password('password', '', ['class' => 'form-control', 'id' => 'password']) ?>
                <div class="input-group-append">
                    <div class="input-group-text cursor-pointer">
                        <i data-feather="eye"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12">
        <?= form_submit(null, 'Lưu Thay Đổi', ['class' => 'btn btn-primary mt-2 mr-1']) ?>
        <?= form_reset(null, 'Reset', ['class' => 'btn btn-outline-secondary mt-2']) ?>
    </div>
</div>
<?= form_close() ?>