<?= $this->extend('templates/backend/master'); ?>

<?= $this->section('title'); ?>
Post List Page
<?= $this->endSection(); ?>

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') ?>
<?= link_tag('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') ?>
<?= link_tag('app-assets/vendors/css/extensions/sweetalert2.min.css') ?>
<?= link_tag('app-assets/vendors/css/forms/select/select2.min.css') ?>
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
<?= script_tag('app-assets/vendors/js/forms/select/select2.full.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<script>
    $(".select2-custom").each(function() {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>');
        $this
            .select2({
                dropdownAutoWidth: true,
                width: "100%",
                placeholder: "Vui Lòng Chọn",
                dropdownParent: $this.parent(),
            })
    });


    var postTable = $('.post-table');
    var url_delete_item = "<?= route_to('admin.post.multiDestroy') ?>";
    var url_status_item = "<?= route_to('admin.post.multiStatus') ?>";
    var url_featured_item = "<?= route_to('admin.post.multiFeatured') ?>";
    var click_mode = 0;

    var aLengthMenuGeneral = [
        [50, 100, 500, 1000],
        [50, 100, 500, 1000]
    ];

    if (postTable.length) {
        var oTable = postTable.DataTable({
            "bServerSide": true,
            "bProcessing": true,
            "sPaginationType": "full_numbers",
            "sAjaxSource": "<?= route_to('admin.post.getList') ?>",
            "bDeferRender": true,
            "bFilter": false,
            "bDestroy": true,
            "aLengthMenu": aLengthMenuGeneral,
            "iDisplayLength": 50,
            "bSort": true,
            columns: [{
                    data: 'checkbox',
                    "bSortable": false
                },
                {
                    data: 'responsive_id',
                    "bSortable": false
                },
                {
                    data: 'image',
                    "bSortable": false
                },
                {
                    data: 'infoPost',
                    "bSortable": false
                },
                {
                    data: 'infoDate',
                    "bSortable": false
                },
                {
                    data: 'infoUser',
                    "bSortable": false
                },
                {
                    data: 'status',
                    "bSortable": false
                },
                {
                    data: 'featured',
                    "bSortable": false
                },
                {
                    data: 'action',
                    "bSortable": false
                },
            ],
            "fnServerParams": function(aoData) {
                if (click_mode == 0) {
                    aoData.push({
                        "name": "search[name]",
                        "value": $('#frmSearch input[name="search[name]"]').val()
                    });
                    aoData.push({
                        "name": "search[status]",
                        "value": $('#frmSearch select[name="search[status]"]').val()
                    });
                    aoData.push({
                        "name": "search[cat_id]",
                        "value": $('#frmSearch select[name="search[cat_id]"]').val()
                    });
                    aoData.push({
                        "name": "search[province_id]",
                        "value": $('#frmSearch select[name="search[province_id]"]').val()
                    });
                    aoData.push({
                        "name": "search[fullname]",
                        "value": $('#frmSearch input[name="search[fullname]"]').val()
                    });
                    aoData.push({
                        "name": "search[gender]",
                        "value": $('#frmSearch select[name="search[gender]"]').val()
                    });
                    aoData.push({
                        "name": "search[email]",
                        "value": $('#frmSearch input[name="search[email]"]').val()
                    });
                    aoData.push({
                        "name": "search[featured]",
                        "value": $('#frmSearch select[name="search[featured]"]').val()
                    });
                } else {
                    aoData.push({
                        "name": "search[status]",
                        "value": <?= STATUS_POST_READY ?>
                    });
                }
            },
            columnDefs: [{
                    className: 'control',
                    orderable: false,
                    responsivePriority: 2,
                    targets: 0
                },
                {
                    targets: 1,
                    orderable: false,
                    responsivePriority: 3,
                    render: function(data, type, full, meta) {
                        return (
                            '<div class="custom-control custom-checkbox checkbox"> <input class="custom-control-input dt-checkboxes checkboxes" type="checkbox" name="chk[]" value="' + $('<div/>').text(data).html() + '" id="checkbox' +
                            data +
                            '" /><label class="custom-control-label" for="checkbox' +
                            data +
                            '"></label></div>'
                        );
                    },
                    checkboxes: {
                        selectAllRender: '<div class="custom-control custom-checkbox checkbox"> <input class="custom-control-input dt-checkboxes" type="checkbox" id="chkAll" /><label class="custom-control-label" for="chkAll"></label></div>'
                    }
                },
                {
                    targets: 6,
                    render: function(data, type, full, meta) {
                        var $status_number = full['status'];
                        var $status = {
                            <?= STATUS_POST_ACTIVE ?>: {
                                title: 'Đang Đăng',
                                class: 'badge-light-success'
                            },
                            <?= STATUS_POST_READY ?>: {
                                title: 'Chưa Duyệt',
                                class: 'badge-light-primary'
                            },
                            <?= STATUS_POST_INACTIVE ?>: {
                                title: 'Không Được Duyệt',
                                class: 'badge-light-danger'
                            },
                            <?= STATUS_POST_HIDDEN ?>: {
                                title: 'Đang Ẩn',
                                class: 'badge-light-warning'
                            },
                        };
                        if (typeof $status[$status_number] === 'undefined') {
                            return data;
                        }
                        return (
                            '<span class="badge badge-pill ' +
                            $status[$status_number].class +
                            '">' +
                            $status[$status_number].title +
                            '</span>'
                        );
                    }
                },
                {
                    targets: 7,
                    render: function(data, type, full, meta) {
                        var $featured_number = full['featured'];
                        var $featured = {
                            <?= FEATURED_ACTIVE ?>: {
                                title: 'Tin VIP',
                                class: 'badge-light-primary'
                            },
                            <?= FEATURED_INACTIVE ?>: {
                                title: 'Thường',
                                class: 'badge-light-danger'
                            },
                        };
                        if (typeof $featured[$featured_number] === 'undefined') {
                            return data;
                        }
                        return (
                            '<span class="badge badge-pill ' +
                            $featured[$featured_number].class +
                            '">' +
                            $featured[$featured_number].title +
                            '</span>'
                        );
                    }
                },
                {
                    targets: -1,
                    title: 'Thao Tác',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        var $id = full['responsive_id'];
                        return (
                            '<div class="d-inline-flex">' +
                            '<a href="<?= current_url() ?>/s' + $id + '/edit" class="item-edit">' +
                            feather.icons['edit'].toSvg({
                                class: 'font-small-4'
                            }) +
                            '</a>' +
                            '<a href="' + full['detail'] + '" class="item-edit px-1">' +
                            feather.icons['eye'].toSvg({
                                class: 'font-small-4'
                            }) +
                            '</a>' +
                            '</div>'
                        );
                    }
                }
            ],
            select: 'multi',
            dom: '<"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return 'Chi Tiết Thông Tin';
                        }
                    }),
                    type: 'column',
                    renderer: function(api, rowIdx, columns) {
                        var data = $.map(columns, function(col, i) {
                            console.log(columns);
                            return col.title !== '' ?
                                '<tr data-dt-row="' +
                                col.rowIndex +
                                '" data-dt-column="' +
                                col.columnIndex +
                                '">' +
                                '<td>' +
                                col.title +
                                ':' +
                                '</td> ' +
                                '<td>' +
                                col.data +
                                '</td>' +
                                '</tr>' :
                                '';
                        }).join('');

                        return data ? $('<table class="table"/>').append(data) : false;
                    }
                }
            },
            language: {
                paginate: {
                    previous: '&nbsp;',
                    next: '&nbsp;'
                }
            },
        });
    }

    $(document).ready(function() {
        $('#btnFrmSearch').on('click', function() {
            click_mode = 0;
            oTable.draw();
        });

        $('#btnReset').on('click', function() {
            click_mode = 1;
            oTable.draw();
        });
    });

    <?php if (session()->getFlashdata('success')) : ?>
        Swal.fire({
            icon: "success",
            title: 'Thành Công!',
            html: "<?= session()->getFlashdata('success') ?>",
            confirmButtonClass: 'btn btn-success',
        })
    <?php endif ?>
</script>
<?= $this->endSection() ?>
<!-- end pageJS -->

<!-- Content-body -->
<?= $this->section('content-body'); ?>
<!-- Advanced Search -->
<section id="advanced-search-datatable">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">Danh Sách Bài Đăng</h4>
                </div>
                <!--Search Form -->
                <div class="card-body mt-2">
                    <?= form_open(route_to('admin.post.getList'), ['id' => 'frmSearch', 'method' => 'GET', 'onsubmit' => 'return false;']) ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-row mb-1">
                                <div class="col-md-6 mb-1">
                                    <?= form_label('Tiêu đề danh mục', 'search[name]', ['class' => 'text-capitalize']) ?>
                                    <?= form_input('search[name]', '', ['class' => 'form-control']) ?>
                                </div>

                                <div class="col-md-6 mb-1">
                                    <?= form_label('Status', 'search[status]', ['class' => 'text-capitalize']) ?>
                                    <?= form_dropdown('search[status]', getOptionStatusPost(), STATUS_POST_READY, ['class' => 'custom-select']) ?>
                                </div>

                                <div class="col-md-6 mb-1">
                                    <?= form_label('Loại Tin', 'search[featured]', ['class' => 'text-capitalize']) ?>
                                    <?= form_dropdown('search[featured]', ['' => 'Vui Lòng Chọn', '1' => 'Tin VIP', '0' => 'Tin Thường'], '', ['class' => 'custom-select']) ?>
                                </div>

                                <div class="col-md-6 mb-1">
                                    <?= form_label('Danh mục', 'search[cat_id]', ['class' => 'text-capitalize']) ?>
                                    <?= form_dropdown('search[cat_id]', [] + $option, '', ['class' => 'form-control select2-custom']) ?>
                                </div>

                                <div class="col-md-6 mb-1">
                                    <?= form_label('Tỉnh/Thành Phố', 'search[province_id]', ['class' => 'text-capitalize']) ?>
                                    <?= form_dropdown('search[province_id]', [] + $province, '', ['class' => 'form-control select2-custom']) ?>
                                </div>

                                <div class="col-md-6 mb-1">
                                    <?= form_label('Họ và tên', 'search[fullname]', ['class' => 'text-capitalize']) ?>
                                    <?= form_input('search[fullname]', '', ['class' => 'form-control']) ?>
                                </div>

                                <div class="col-md-6 mb-1">
                                    <?= form_label('Giới Tính', 'search[gender]', ['class' => 'text-capitalize']) ?>
                                    <?= form_dropdown('search[gender]', ['' => 'Vui Lòng Chọn', GENDER_FEMALE => 'Nữ', GENDER_MALE => 'Nam'], '', ['class' => 'custom-select']) ?>
                                </div>

                                <div class="col-md-6 mb-1">
                                    <?= form_label('E-mail', 'search[email]', ['class' => 'text-capitalize']) ?>
                                    <?= form_input('search[email]', '', ['class' => 'form-control']) ?>
                                </div>
                            </div>

                            <div class="form-row mb-1">
                                <div class="col-md-12 text-center">
                                    <?= form_submit(null, 'Search', ['class' => 'btn btn-sm btn-primary', 'id' => 'btnFrmSearch']) ?>
                                    <?= form_reset(null, 'Reset', ['class' => 'btn btn-sm btn-warning', 'id' => 'btnReset']) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?= form_close() ?>
                </div>
                <hr class="my-0" />
                <div class="card-header border-bottom p-1">
                    <div class="dt-action-buttons text-right">
                        <div class="dt-buttons d-inline-flex flex-wrap">
                            <button class="dt-button btn btn-danger mr-50" type="button" id="btn-delete">
                                <span>Xóa</span>
                            </button>

                            <button class="dt-button btn btn-primary mr-50 btn-vip" type="button" data-featured="1">
                                <span>VIP ON</span>
                            </button>

                            <button class="dt-button btn btn-primary mr-50 btn-vip" type="button" data-featured="0">
                                <span>VIP OFF</span>
                            </button>

                            <button class="dt-button btn btn-success mr-50 btn-status" type="button" data-status="0">
                                <span>Duyệt Tin</span>
                            </button>

                            <button class="dt-button btn btn-warning mr-50 btn-status" type="button" data-status="3">
                                <span>Ẩn Tin</span>
                            </button>

                            <button class="dt-button btn btn-danger mr-50 btn-status" type="button" data-status="2">
                                <span>Không Duyệt</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-datatable">
                    <?= form_open('', ['id' => 'frmTbList']) ?>
                    <table class="dt-advanced-search dt-responsive table post-table table-white-space">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th></th>
                                <th>Thông tin bài đăng</th>
                                <th>Thông tin gói đăng tin</th>
                                <th>Thông tin người đăng</th>
                                <th>Trạng thái</th>
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
</section>
<!--/ Advanced Search -->
<?= $this->endSection(); ?>
<!-- end Content-body -->