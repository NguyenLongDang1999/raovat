<?= form_open_multipart(route_to('user.user.update'), ['id' => 'update-user-form']) ?>
<?= form_hidden('checkImg', isset(user()->avatar) ? user()->avatar : '') ?>
<div class="media">
    <a href="javascript:void(0);" class="mr-25">
        <?= img(userShowImage(user()->avatar, user()->provider_name, user()->provider_uid), false, ['class' => 'rounded mr-50', 'id' => 'blog-feature-image', 'alt' => esc(user()->fullname), 'height' => '80', 'width' => '80']) ?>
    </a>
    <div class="media-body mt-75 ml-1">
        <label for="blogCustomFile" class="btn btn-sm btn-primary mb-75 mr-75">Upload</label>
        <input type="file" id="blogCustomFile" hidden accept="image/*" name="avatar" />
        <button type="reset" class="btn btn-sm btn-outline-secondary mb-75">Reset</button>
        <p>Châp nhận JPG, GIF hoặc PNG.</p>
    </div>
</div>
<div class="row mt-1">
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?= form_label('E-mail', 'email') ?>
            <?= form_input('email', user()->email, ['class' => 'form-control', 'id' => 'email', 'disabled' => 'disabled']) ?>
        </div>
    </div>
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?= form_label('Họ Và Tên', 'fullname') ?>
            <?= form_input('fullname', user()->fullname, ['class' => 'form-control', 'id' => 'fullname']) ?>
        </div>
    </div>
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?= form_label('Số Điện Thoại', 'phone') ?>
            <?= form_input('phone', user()->phone ? user()->phone : '', ['class' => 'form-control', 'id' => 'phone']) ?>
        </div>
    </div>
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?= form_label('Nghề Nghiệp', 'job') ?>
            <?= form_input('job', user()->job ? user()->job : '', ['class' => 'form-control', 'id' => 'job']) ?>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <?= form_label('Ngày Sinh', 'birthdate') ?>
            <?= form_input('birthdate', user()->birthdate ? user()->birthdate : '', ['class' => 'form-control flatpickr', 'id' => 'birthdate']) ?>
        </div>
    </div>
    <div class="col-12">
        <div class="form-group">
            <?= form_label('Địa Chỉ', 'address') ?>
            <?= form_textarea('address', user()->address ? user()->address : '', ['class' => 'form-control', 'id' => 'address', 'rows' => 3]) ?>
        </div>
    </div>
    <div class="col-12 col-sm-6">
        <div class="form-group">
            <?= form_label('Giới tính', '', ['class' => 'd-block text-capitalize']) ?>
            <div class="custom-control custom-radio my-50">
                <?= form_radio('gender', '1', user()->gender == 1 ? true : false, ['class' => 'custom-control-input', 'id' => 'male']) ?>
                <?= form_label('Nam', 'male', ['class' => 'custom-control-label']) ?>
            </div>
            <div class="custom-control custom-radio">
                <?= form_radio('gender', '0', user()->gender == 0 ? true : false, ['class' => 'custom-control-input', 'id' => 'female']) ?>
                <?= form_label('Nữ', 'female', ['class' => 'custom-control-label']) ?>
            </div>
        </div>
    </div>
    <div class="col-12">
        <?= form_submit(null, 'Lưu Thay Đổi', ['class' => 'btn btn-primary mt-2 mr-1']) ?>
        <?= form_reset(null, 'Reset', ['class' => 'btn btn-outline-secondary mt-2']) ?>
    </div>
</div>
<?= form_close() ?>