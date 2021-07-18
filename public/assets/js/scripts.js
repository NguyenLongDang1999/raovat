(function (window, undefined) {
    "use strict";

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="X-CSRF-TOKEN"]').attr("content"),
        },
    });

    $.extend($.fn.dataTable.defaults, {
        "language": {
            "sProcessing": "Processing...",
            "sLengthMenu": "Hiển Thị _MENU_ Kết Quả",
            "sZeroRecords": "Không Có Dữ Liệu Nào Được Hiển Thị",
            "sEmptyTable": "Không Có Dữ Liệu Nào Được Hiển Thị",
            "sInfoEmpty": "Hiển Thị Từ 0 Đến 0 Trong Tổng Số 0",
            "sInfo": "Hiển Thị Từ _START_ Đến _END_ Trong Tổng Số _TOTAL_",
            "oPaginate": {
                "sFirst": "Đầu",
                "sPrevious": "&nbsp;",
                "sNext": "&nbsp;",
                "sLast": "Cuối"
            }
        }
    });

    var blogFeatureImage = $("#blog-feature-image");
    var blogImageInput = $("#blogCustomFile");
    var select = $(".select2");
    var flat_picker = $(".flatpickr");
    var numeralMask = $(".numeral-mask");
    const altFormat = "d-m-Y";

    if (flat_picker.length) {
        flat_picker.flatpickr({
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat,
            allowInput: true,
            onReady: function (selectedDates, dateStr, instance) {
                if (instance.isMobile) {
                    $(instance.mobileInput).attr("step", null);
                }
            },
        });
    }

    if (numeralMask.length) {
        new Cleave(numeralMask, {
            numeral: true,
            numeralThousandsGroupStyle: "thousand",
        });
    }

    function isChecked() {
        var checkAll = $("#chkAll").attr("checked");
        var flag = false;
        $("input.checkboxes").each(function (index, element) {
            if (element.checked) {
                flag = true;
            }
        });
        if (checkAll || flag) {
            flag = true;
        }
        return flag;
    }

    function notify_cancel(text = "Không Có Mục Nào Được Chọn") {
        Swal.fire({
            icon: "warning",
            title: "Cảnh Báo!",
            text: text,
        });
    }

    function notify_success(html) {
        Swal.fire({
            icon: "success",
            title: "Thành Công!",
            html: html,
            confirmButtonClass: "btn btn-success",
        });
    }

    function deleteAllItem(data) {
        Swal.fire({
            title: "Bạn Có Chắn Chắn Muốn Xóa Không ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Đồng Ý",
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-danger ml-1",
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                var deleteItem = $.ajax({
                    type: "post",
                    url: url_delete_item,
                    async: true,
                    cache: false,
                    data: {
                        data: data,
                    },
                });
                deleteItem.done(function (resp) {
                    resp = jQuery.parseJSON(resp);
                    if (resp.result) {
                        oTable.draw();
                        notify_success(resp.message);
                    } else {
                        oTable.draw();
                        Swal.fire({
                            icon: "error",
                            title: "Thất Bại!",
                            html: resp.message,
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Thất Bại!",
                    html: "Chưa Có Dữ Liệu Nào Được Xóa.",
                });
            }
        });
    }

    function restoreAllItem(data) {
        Swal.fire({
            title: "Bạn Có Chắn Chắn Muốn Khôi Phục Không ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Đồng Ý",
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-danger ml-1",
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                var restoreItem = $.ajax({
                    type: "post",
                    url: url_restore_item,
                    async: true,
                    cache: false,
                    data: {
                        data: data,
                    },
                });
                restoreItem.done(function (resp) {
                    resp = jQuery.parseJSON(resp);
                    if (resp.result) {
                        oTable.draw();
                        notify_success(resp.message);
                    } else {
                        oTable.draw();
                        Swal.fire({
                            icon: "error",
                            title: "Thất Bại!",
                            html: resp.message,
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Thất Bại!",
                    html: "Chưa Có Dữ Liệu Nào Được Khôi Phục.",
                });
            }
        });
    }

    function statusAllItem(data, status) {
        Swal.fire({
            title: "Bạn Có Chắn Chắn Muốn Cập Nhật Trạng Thái Không ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Đồng Ý",
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-danger ml-1",
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                var updateStatus = $.ajax({
                    type: "post",
                    url: url_status_item,
                    async: true,
                    cache: false,
                    data: {
                        data: data,
                        status: status,
                    },
                });
                updateStatus.done(function (resp) {
                    resp = jQuery.parseJSON(resp);
                    if (resp.result) {
                        oTable.draw();
                        notify_success(resp.message);
                    } else {
                        oTable.draw();
                        Swal.fire({
                            icon: "error",
                            title: "Thất Bại!",
                            html: resp.message,
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Thất Bại!",
                    html: "Chưa Có Dữ Liệu Nào Được Cập Nhật.",
                });
            }
        });
    }

    function favoritesAllItem(post_id) {
        Swal.fire({
            title: "Bạn có chắc chắn sẽ lưu bài đăng này ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Đồng Ý",
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-danger ml-1",
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                var updateFavorites = $.ajax({
                    type: "post",
                    url: url_favorites_item,
                    async: true,
                    cache: false,
                    data: {
                        post_id: post_id,
                    },
                });
                updateFavorites.done(function (resp) {
                    resp = jQuery.parseJSON(resp);
                    if (resp.result) {
                        notify_success(resp.message);
                    } else {
                        Swal.fire({
                            icon: "error",
                            title: "Thất Bại!",
                            html: resp.message,
                        });
                    }
                });
                updateFavorites.always(function () {
                    showFavorites();
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Thất Bại!",
                    html: "Chưa Có Dữ Liệu Nào Được Cập Nhật.",
                });
            }
        });
    }


    function removeFavoritesItem(data) {
        Swal.fire({
            title: "Bài Đăng Này Sẽ Được Đưa Ra Khỏi Danh Sách Lưu. Đồng Ý ?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Đồng Ý",
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-danger ml-1",
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                var updateFavorites = $.ajax({
                    type: "post",
                    url: url_remove_favorites_item,
                    async: true,
                    cache: false,
                    data: {
                        data: data,
                    },
                });
                updateFavorites.done(function (resp) {
                    resp = jQuery.parseJSON(resp);
                    if (resp.result) {
                        oTable.draw();
                        showFavorites();
                        notify_success(resp.message);
                    } else {
                        oTable.draw();
                        Swal.fire({
                            icon: "error",
                            title: "Thất Bại!",
                            html: resp.message,
                        });
                    }
                });
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Thất Bại!",
                    html: "Chưa Có Dữ Liệu Nào Được Cập Nhật.",
                });
            }
        });
    }

    function featuredAllItem(data, featured) {
        Swal.fire({
            title: 'Bạn Có Chắn Chắn Muốn Kích Hoạt VIP Không ?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Đồng Ý",
            confirmButtonClass: "btn btn-primary",
            cancelButtonClass: "btn btn-danger ml-1",
            buttonsStyling: false,
        }).then(function (result) {
            if (result.value) {
                var updateFeatured = $.ajax({
                    type: "post",
                    url: url_featured_item,
                    async: true,
                    cache: false,
                    data: {
                        data: data,
                        featured: featured,
                    },
                });
                updateFeatured.done(function (resp) {
                    resp = jQuery.parseJSON(resp);
                    if (resp.result) {
                        oTable.draw();
                        notify_success(resp.message);
                    } else {
                        oTable.draw();
                        Swal.fire({
                            icon: "error",
                            title: "Thất Bại!",
                            html: resp.message,
                        });
                    }
                });
            } else {
                Swal.fire(
                    {
                        icon: "error",
                        title: 'Thất Bại!',
                        html: 'Chưa Có Dữ Liệu Nào Được Cập Nhật.',
                    }
                )
            }
        })
    }

    select.each(function () {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>');
        $this
            .select2({
                dropdownAutoWidth: true,
                width: "100%",
                placeholder: "Vui Lòng Chọn",
                dropdownParent: $this.parent(),
            })
            .change(function () {
                $(this).valid();
            });
    });

    if (blogImageInput.length) {
        $(blogImageInput).on("change", function (e) {
            var reader = new FileReader(),
                files = e.target.files;
            reader.onload = function () {
                if (blogFeatureImage.length) {
                    blogFeatureImage.attr("src", reader.result);
                }
            };
            reader.readAsDataURL(files[0]);
        });
    }

    $(document).on("click", "#btn-delete", function () {
        var is_checked = isChecked();

        if (is_checked) {
            deleteAllItem($("#frmTbList").serialize());
        } else {
            notify_cancel();
        }
    });

    $(document).on("click", ".btn-favorites", function () {
        var is_checked = isChecked();

        if (is_checked) {
            removeFavoritesItem($("#frmTbListSave").serialize());
            showFavorites();
        } else {
            notify_cancel();
        }
    });

    $(document).on("click", ".btn-status", function () {
        var is_checked = isChecked();
        var status = $(this).data("status");

        if (is_checked) {
            statusAllItem($("#frmTbList").serialize(), status);
        } else {
            notify_cancel();
        }
    });

    $(document).on("click", ".btn-wishlist", function () {
        var favorites = $(this).data("favorites");
        var post_id = $(this).data("id");

        if (favorites == 1) {
            favoritesAllItem(post_id);
        } else {
            notify_cancel("Vui Lòng Đăng Nhập Để Lưu Lại Bài Đăng.");
        }
    });

    $(document).on('click', '.btn-vip', function () {
        var is_checked = isChecked();
        var featured = $(this).data("featured");

        if (is_checked) {
            featuredAllItem($("#frmTbList").serialize(), featured);
        } else {
            notify_cancel();
        }
    });

    $(document).on("click", "#btn-restore", function () {
        var is_checked = isChecked();

        if (is_checked) {
            restoreAllItem($("#frmTbList").serialize());
        } else {
            notify_cancel();
        }
    });

    $(document).on("change", "#province_id", function () {
        var province_id = $(this).val();

        $.ajax({
            url: url_showDistrict,
            type: "post",
            async: true,
            cache: false,
            data: {
                province_id: province_id,
            },
        }).done(function (data) {
            data = jQuery.parseJSON(data);
            $("#district_id").html(data.getDistrict);
        });
    });

    function showFavorites() {
        $.ajax({
            url: '/showFavorites',
            type: "post",
            async: true,
            cache: false,
        }).done(function (data) {
            $(".dropdown-cart").html(data);

            if (feather) {
                feather.replace({
                    width: 14,
                    height: 14
                });
            }
        });
    }

    showFavorites();
})(window);