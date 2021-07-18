<?= $this->extend('templates/backend/master'); ?>

<?= $this->section('title'); ?>
Category List Page
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
<script>
    var categoryTable = $('.category-table');
    var url_delete_item = "<?= route_to('admin.category.multiDestroy') ?>";
    var url_status_item = "<?= route_to('admin.category.multiStatus') ?>";
    var click_mode = 0;
    var aLengthMenuGeneral = [
        [20, 50, 100, 500, 1000],
        [20, 50, 100, 500, 1000]
    ];

    if (categoryTable.length) {
        var oTable = categoryTable.DataTable({
            "bServerSide": true,
            "bProcessing": true,
            "sPaginationType": "full_numbers",
            "sAjaxSource": "<?= route_to('admin.category.getList') ?>",
            "bDeferRender": true,
            "bFilter": false,
            "bDestroy": true,
            "aLengthMenu": aLengthMenuGeneral,
            "iDisplayLength": 20,
            "bSort": true,
            "aaSorting": [
                [5, "desc"]
            ],
            columns: [{
                    data: 'checkbox',
                    "bSortable": false
                },
                {
                    data: 'responsive_id',
                    "bSortable": false
                },
                {
                    data: 'name'
                },
                {
                    data: 'parent_id',
                    "bSortable": false
                },
                {
                    data: 'status',
                    "bSortable": false
                },
                {
                    data: 'created_at'
                },
                {
                    data: 'updated_at'
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
                    targets: 4,
                    render: function(data, type, full, meta) {
                        var $status_number = full['status'];
                        var $status = {
                            1: {
                                title: 'ON',
                                class: 'badge-light-primary'
                            },
                            0: {
                                title: 'OFF',
                                class: ' badge-light-danger'
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
                    targets: -1,
                    title: 'Thao Tác',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        var $id = full['responsive_id'];
                        return (
                            '<a href="<?= current_url() ?>/edit/' + $id + '" class="item-edit">' +
                            feather.icons['edit'].toSvg({
                                class: 'font-small-4'
                            }) +
                            '</a>'
                        );
                    }
                }
            ],
            select: 'multi',
            dom: 'r <"d-flex justify-content-between align-items-center mx-0 row"<"col-sm-12 col-md-6"l><"col-sm-12 col-md-6"f>>t<"d-flex justify-content-between mx-0 row"<"col-sm-12 col-md-6"i><"col-sm-12 col-md-6"p>>',
            responsive: {
                details: {
                    display: $.fn.dataTable.Responsive.display.modal({
                        header: function(row) {
                            var data = row.data();
                            return 'Chi Tiết Thông Tin ' + data['name'];
                        }
                    }),
                    type: 'column',
                    renderer: function(api, rowIdx, columns) {
                        var data = $.map(columns, function(col, i) {
                            console.log(columns);
                            return col.title !== ''
                                ?
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
                    <h4 class="card-title">Danh Mục Đăng Tin</h4>
                </div>
                <!--Search Form -->
                <div class="card-body mt-2">
                    <?= form_open(route_to('admin.category.getList'), ['id' => 'frmSearch', 'method' => 'GET', 'onsubmit' => 'return false;']) ?>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-row mb-1">
                                <div class="col-md-6 mb-1">
                                    <?= form_label('Tiêu đề danh mục', 'search[name]', ['class' => 'text-capitalize']) ?>
                                    <?= form_input('search[name]', '', ['class' => 'form-control']) ?>
                                </div>

                                <div class="col-md-6 mb-1">
                                    <?= form_label('Status', 'search[status]', ['class' => 'text-capitalize']) ?>
                                    <?= form_dropdown('search[status]', ['' => 'Vui Lòng Chọn', '1' => 'ON', '0' => 'OFF'], '', ['class' => 'custom-select']) ?>
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
                        <div class="dt-buttons d-inline-flex">
                            <button class="dt-button btn btn-danger mr-50" type="button" id="btn-delete">
                                <span>Xóa</span>
                            </button>

                            <button class="dt-button btn btn-primary mr-50 btn-status" type="button" data-status="1">
                                <span>STATUS ON</span>
                            </button>

                            <button class="dt-button btn btn-primary btn-status" type="button" data-status="0">
                                <span>STATUS OFF</span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card-datatable">
                    <?= form_open('', ['id' => 'frmTbList']) ?>
                    <table class="dt-advanced-search dt-responsive table category-table table-white-space">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Tiêu Đề</th>
                                <th>Danh mục cha</th>
                                <th>Trạng Thái</th>
                                <th>Ngày Tạo</th>
                                <th>Ngày Sửa</th>
                                <th>Thao Tác</th>
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