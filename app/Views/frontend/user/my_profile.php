<?= $this->extend('templates/frontend/master'); ?>

<?= $this->section('title'); ?>
Thông tin cá nhân
<?= $this->endSection(); ?>

<!-- vendorCSS -->
<?= $this->section('vendorCSS') ?>
<?= link_tag('app-assets/vendors/css/charts/apexcharts.css') ?>
<?= link_tag('app-assets/vendors/css/pickers/flatpickr/flatpickr.min.css') ?>
<?= link_tag('app-assets/vendors/css/tables/datatable/dataTables.bootstrap4.min.css') ?>
<?= link_tag('app-assets/vendors/css/tables/datatable/responsive.bootstrap4.min.css') ?>
<?= $this->endSection() ?>
<!-- end vendorCSS -->

<!-- pageCSS -->
<?= $this->section('pageCSS') ?>
<?= link_tag('app-assets/css/pages/page-profile.min.css') ?>
<?= link_tag('app-assets/css/plugins/charts/chart-apex.css') ?>
<?= $this->endSection() ?>
<!-- end pageCSS -->

<!-- vendorJS -->
<?= $this->section('vendorJS') ?>
<?= script_tag('app-assets/vendors/js/charts/apexcharts.min.js') ?>
<?= script_tag('app-assets/vendors/js/tables/datatable/jquery.dataTables.min.js') ?>
<?= script_tag('app-assets/vendors/js/tables/datatable/datatables.bootstrap4.min.js') ?>
<?= script_tag('app-assets/vendors/js/tables/datatable/dataTables.responsive.min.js') ?>
<?= script_tag('app-assets/vendors/js/tables/datatable/responsive.bootstrap4.min.js') ?>
<?= $this->endSection() ?>
<!-- end vendorJS -->

<!-- pageJS -->
<?= $this->section('pageJS') ?>
<?= script_tag('app-assets/js/scripts/pages/page-profile.min.js') ?>
<script>
    var click_mode = 0;
    var aLengthMenuGeneral = [
        [20, 50, 100, 500, 1000],
        [20, 50, 100, 500, 1000]
    ];

    var oTableActive = $('#get-post-list').DataTable({
        "bServerSide": true,
        "bProcessing": true,
        "sPaginationType": "full_numbers",
        "sAjaxSource": "<?= route_to('user.manager.getPostList') ?>",
        "bDeferRender": true,
        "bFilter": false,
        "bDestroy": true,
        "aLengthMenu": aLengthMenuGeneral,
        "iDisplayLength": 20,
        "bSort": false,
        columns: [{
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
                data: 'featured',
                "bSortable": false
            },
            {
                data: 'status',
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
                    "value": <?= STATUS_POST_ACTIVE ?>
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
                targets: 4,
                render: function(data, type, full, meta) {
                    var $featured_number = full['featured'];
                    var $featured = {
                        <?= FEATURED_ACTIVE ?>: {
                            title: 'Tin VIP',
                            class: 'badge-light-primary'
                        },
                        <?= FEATURED_INACTIVE ?>: {
                            title: 'Bình Thường',
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
                targets: 5,
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
                targets: -1,
                title: 'Thao Tác',
                orderable: false,
                render: function(data, type, full, meta) {
                    var $id = full['responsive_id'];
                    return (
                        '<div class="d-inline-flex">' +
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

    $(function() {
        'use strict';

        var chartColors = {
            donut: {
                series1: '#ffe700',
                series2: '#00d4bd',
                series3: '#826bf8',
                series4: '#2b9bf4',
                series5: '#FFA1A1'
            },
        };

        var donutChartEl = document.querySelector('#donut-chart'),
            donutChartConfig = {
                chart: {
                    height: 350,
                    type: 'donut'
                },
                legend: {
                    show: true,
                    position: 'bottom'
                },
                labels: ['Operational', 'Networking', 'Hiring', 'R&D'],
                series: [85, 16, 50, 50],
                colors: [
                    chartColors.donut.series1,
                    chartColors.donut.series5,
                    chartColors.donut.series3,
                    chartColors.donut.series2
                ],
                dataLabels: {
                    enabled: true,
                    formatter: function(val, opt) {
                        return parseInt(val) + '%';
                    }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            labels: {
                                show: true,
                                name: {
                                    fontSize: '2rem',
                                    fontFamily: 'Montserrat'
                                },
                                value: {
                                    fontSize: '1rem',
                                    fontFamily: 'Montserrat',
                                    formatter: function(val) {
                                        return parseInt(val) + '%';
                                    }
                                },
                                total: {
                                    show: true,
                                    fontSize: '1.5rem',
                                    label: 'Operational',
                                    formatter: function(w) {
                                        return '31%';
                                    }
                                }
                            }
                        }
                    }
                },
                responsive: [{
                        breakpoint: 992,
                        options: {
                            chart: {
                                height: 380
                            }
                        }
                    },
                    {
                        breakpoint: 576,
                        options: {
                            chart: {
                                height: 320
                            },
                            plotOptions: {
                                pie: {
                                    donut: {
                                        labels: {
                                            show: true,
                                            name: {
                                                fontSize: '1.5rem'
                                            },
                                            value: {
                                                fontSize: '1rem'
                                            },
                                            total: {
                                                fontSize: '1.5rem'
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                ]
            };
        if (typeof donutChartEl !== undefined && donutChartEl !== null) {
            var donutChart = new ApexCharts(donutChartEl, donutChartConfig);
            donutChart.render();
        }
    })
</script>
<?= $this->endSection() ?>
<!-- end pageJS -->

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
                                        <li class="breadcrumb-item active" aria-current="page">Thông Tin Cá Nhân</li>
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
<section class="page-user-profile">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="user-profile-images">
                    <?= img('app-assets/images/profile/user-uploads/timeline.jpg', false, ['class' => 'w-100', 'alt' => 'User Image']) ?>
                    <?= img(userShowImage(user()->avatar), false, ['class' => 'user-profile-image rounded', 'width' => 140, 'height' => 140, 'alt' => esc(user()->fullname)]) ?>
                </div>
                <div class="user-profile-text">
                    <h4 class="mb-0 text-bold-500 profile-text-color"><?= esc(user()->fullname) ?></h4>
                    <small><?= esc(user()->job) ?></small>
                </div>
                <div class="card-body px-0">
                    <ul class="nav user-profile-nav justify-content-center justify-content-md-start nav-pills border-bottom-0 mb-0" role="tablist">
                        <li class="nav-item mb-0 mr-0">
                            <a class="nav-link d-flex px-1 active" id="profile-tab" data-toggle="tab" href="#profile" aria-controls="profile" role="tab" aria-selected="false">
                                <i data-feather='users'></i>
                                <span class="d-none d-md-block">Profile</span></a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-9">
                    <div class="tab-content">
                        <div class="tab-pane active" id="profile" aria-labelledby="profile-tab" role="tabpanel">

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Thông Tin Chi Tiết</h5>
                                    <div class="row">
                                        <div class="col-sm-4 col-12">
                                            <h6>Số Điện Thoại</h6>
                                            <p><?= esc(user()->phone) ?></p>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <h6>E-mail</h6>
                                            <p><?= esc(user()->email) ?></p>
                                        </div>
                                        <div class="col-sm-4 col-12">
                                            <h6>Ngày Tham Gia</h6>
                                            <p><?= esc(getDateTime(user()->created_at)) ?></p>
                                        </div>
                                        <div class="col-12">
                                            <h6>Địa Chỉ</h6>
                                            <p><?= !empty(user()->address) ? esc(user()->address) : 'Chưa Cập Nhật' ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">Bài Đăng Đang Hoạt Động</h5>

                                    <?= form_open('', ['id' => 'frmTbList']) ?>
                                    <table class="dt-advanced-search dt-responsive table table-white-space" id="get-post-list">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Hình ảnh</th>
                                                <th>Thông tin bài đăng</th>
                                                <th>Gói đăng tin</th>
                                                <th>Loại tin</th>
                                                <th>Trạng thái</th>
                                                <th>Thao tác</th>
                                            </tr>
                                        </thead>
                                    </table>
                                    <?= form_close() ?>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-header flex-column align-items-start">
                            <h4 class="card-title mb-75">Expense Ratio</h4>
                            <span class="card-subtitle text-muted">Spending on various categories </span>
                        </div>
                        <div class="card-body">
                            <div id="donut-chart"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?= $this->endSection(); ?>
<!-- end Content-body -->