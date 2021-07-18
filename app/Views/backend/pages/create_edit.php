<?= $this->extend('templates/backend/master'); ?>

<?= $this->section('title'); ?>
Pages <?= isset($row) ? 'Update' : 'Create' ?>
<?= $this->endSection(); ?>

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/editors/quill/quill.snow.css') ?>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/plugins/forms/form-quill-editor.min.css') ?>
<?= link_tag('app-assets/css/plugins/forms/form-validation.css') ?>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/editors/quill/quill.min.js') ?>
<?= script_tag('app-assets/vendors/js/forms/validation/jquery.validate.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<script>
    var editor = "#blog-editor-container .editor";

    var Font = Quill.import("formats/font");
    Font.whitelist = ["sofia", "slabo", "roboto", "inconsolata", "ubuntu"];
    Quill.register(Font, true);

    var pagesEditor = new Quill(editor, {
        bounds: editor,
        modules: {
            toolbar: [
                [{
                        font: [],
                    },
                    {
                        size: [],
                    },
                ],
                ["bold", "italic", "underline", "strike"],
                [{
                        color: [],
                    },
                    {
                        background: [],
                    },
                ],
                [{
                        script: "super",
                    },
                    {
                        script: "sub",
                    },
                ],
                [{
                        header: "1",
                    },
                    {
                        header: "2",
                    },
                    "blockquote",
                    "code-block",
                ],
                [{
                        list: "ordered",
                    },
                    {
                        list: "bullet",
                    },
                    {
                        indent: "-1",
                    },
                    {
                        indent: "+1",
                    },
                ],
                [
                    "direction",
                    {
                        align: [],
                    },
                ],
                ['link', 'image', 'video'],
                ["clean"],
            ],
        },
        theme: "snow",
    });

    pagesEditor.on('text-change', function(delta, oldDelta, source) {
        document.getElementById("quill_html").value = pagesEditor.root.innerHTML;
    });

    $(function() {
        'use strict';
        var pagesForm = $('#pages-form');
        if (pagesForm.length) {
            pagesForm.validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 255,
                    },
                    meta_keyword: {
                        maxlength: 60
                    },
                    meta_description: {
                        maxlength: 160
                    },
                },
                messages: {
                    name: {
                        required: "Tiêu đề banner không được bỏ trống.",
                        maxlength: "Tiêu đề banner không được vượt quá 255 ký tự.",
                    },
                    meta_keyword: {
                        maxlength: "Meta Keyword (SEO) không được vượt quá 60 ký tự.",
                    },
                    meta_description: {
                        maxlength: "Meta Description (SEO) không được vượt quá 160 ký tự."
                    }
                },

            });
        }
    });
</script>
<?= $this->endSection() ?>
<!-- end pageJS -->

<!-- Content-body -->
<?= $this->section('content-body'); ?>
<section class="bs-validation">
    <div class="row">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header border-bottom">
                    <h4 class="card-title"><?= isset($row) ? 'Cập Nhật ' . esc($row['name']) : 'Thêm Mới' ?></h4>
                </div>

                <div class="card-body mt-2">
                    <?php if (isset($row)) : ?>
                        <?= form_open(route_to('admin.pages.update', esc($row['id'])), ['id' => 'pages-form']) ?>
                    <?php else : ?>
                        <?= form_open(route_to('admin.pages.store'), ['id' => 'pages-form']) ?>
                    <?php endif; ?>

                    <input type="hidden" id="quill_html" name="description" />

                    <div class="form-group">
                        <?= form_label('Tiêu đề pages', 'name', ['class' => 'form-label text-capitalize']) ?>
                        <?= form_input('name', isset($row) ? $row['name'] : '', ['class' => 'form-control', 'id' => 'name']) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Mô tả pages', 'description', ['class' => 'form-label text-capitalize']) ?>
                        <div id="blog-editor-wrapper">
                            <div id="blog-editor-container">
                                <div class="editor">
                                    <?= isset($row) ? $row['description'] : '' ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <?= form_label('Meta Keyword (SEO)', 'meta_keyword', ['class' => 'form-label text-capitalize']) ?>
                        <?= form_textarea('meta_keyword', isset($row) ? $row['meta_keyword'] : '', ['class' => 'form-control', 'id' => 'meta_keyword', 'rows' => 3]) ?>
                    </div>

                    <div class="form-group">
                        <?= form_label('Meta Description (SEO)', 'meta_description', ['class' => 'form-label text-capitalize']) ?>
                        <?= form_textarea('meta_description', isset($row) ? $row['meta_description'] : '', ['class' => 'form-control', 'id' => 'meta_description', 'rows' => 3]) ?>
                    </div>

                    <div class="row">
                        <div class="col-12">
                            <?= form_submit('submit', 'Lưu', ['class' => 'btn btn-primary']) ?>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->