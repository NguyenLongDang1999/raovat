<script>
    $(function() {
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
                    targets: 5,
                    render: function(data, type, full, meta) {
                        var $featured_number = full['featured'];
                        var $featured = {
                            1: {
                                title: 'VIP',
                                class: 'badge-light-primary'
                            },
                            0: {
                                title: 'Bình Thường',
                                class: ' badge-light-danger'
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
                    targets: 6,
                    render: function(data, type, full, meta) {
                        var $status_number = full['status'];
                        var $status = {
                            1: {
                                title: 'Đang Đăng',
                                class: 'badge-light-primary'
                            },
                            0: {
                                title: 'Chưa Duyệt',
                                class: ' badge-light-danger'
                            },
                            2: {
                                title: 'Không Được Duyệt',
                                class: ' badge-light-danger'
                            },
                            3: {
                                title: 'Đang Ẩn',
                                class: ' badge-light-warning'
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
                            '<a href="<?= current_url() ?>/s' + $id + '/edit" class="item-edit">' +
                            feather.icons['edit'].toSvg({
                                class: 'font-small-4'
                            }) +
                            '</a>'
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

        var oTableBlock = $('#get-manager-block').DataTable({
            "bServerSide": true,
            "bProcessing": true,
            "sPaginationType": "full_numbers",
            "sAjaxSource": "<?= route_to('user.manager.getPostListBlock') ?>",
            "bDeferRender": true,
            "bFilter": false,
            "bDestroy": true,
            "aLengthMenu": aLengthMenuGeneral,
            "iDisplayLength": 20,
            "bSort": true,
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
                        "value": <?= STATUS_POST_INACTIVE ?>
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
                            1: {
                                title: 'VIP',
                                class: 'badge-light-primary'
                            },
                            0: {
                                title: 'Bình Thường',
                                class: ' badge-light-danger'
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
                            '<a href="<?= current_url() ?>/s' + $id + '/edit" class="item-edit">' +
                            feather.icons['edit'].toSvg({
                                class: 'font-small-4'
                            }) +
                            '</a>'
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

        var oTableReady = $('#get-manager-ready').DataTable({
            "bServerSide": true,
            "bProcessing": true,
            "sPaginationType": "full_numbers",
            "sAjaxSource": "<?= route_to('user.manager.getPostListReady') ?>",
            "bDeferRender": true,
            "bFilter": false,
            "bDestroy": true,
            "aLengthMenu": aLengthMenuGeneral,
            "iDisplayLength": 20,
            "bSort": true,
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
                    targets: 4,
                    render: function(data, type, full, meta) {
                        var $featured_number = full['featured'];
                        var $featured = {
                            1: {
                                title: 'VIP',
                                class: 'badge-light-primary'
                            },
                            0: {
                                title: 'Bình Thường',
                                class: ' badge-light-danger'
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
                            '<a href="<?= current_url() ?>/s' + $id + '/edit" class="item-edit">' +
                            feather.icons['edit'].toSvg({
                                class: 'font-small-4'
                            }) +
                            '</a>'
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

        $('#tabMenu a').click(function(e) {
            e.preventDefault();
            $(this).tab('show');
            var id = $(this).attr("href");
            localStorage.setItem('activeTabManager', id);
        });

        $('#tabMenu a[href="' + localStorage.getItem('activeTabManager') + '"]').tab('show');

        setIndexTab(localStorage.getItem('activeTabManager'));

        $('a[data-toggle="pill"]').on('shown.bs.tab', function(event) {
            $($.fn.dataTable.tables(true)).css('width', '100%');
            $($.fn.dataTable.tables(true)).DataTable().columns.adjust().draw();
            var href = $(this).attr('href');
            setIndexTab(href);
        });

        function setIndexTab(tab) {
            switch (tab) {
                case '#manager-active':
                    url_status_item = "<?= route_to('user.post.multiStatus') ?>";
                    oTable = oTableActive;
                    break;

                case '#manager-block':
                    break;

                case '#manager-ready':
                    break;

                default:
                    break;
            }
        }
    })
</script>