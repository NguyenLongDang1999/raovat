(function(window, undefined) {
    "use strict";

    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="X-CSRF-TOKEN"]').attr("content"),
        },
    });

    $('.lazy').lazy();
    
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
            onReady: function(selectedDates, dateStr, instance) {
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
        $("input.checkboxes").each(function(index, element) {
            if (element.checked) {
                flag = true;
            }
        });
        if (checkAll || flag) {
            flag = true;
        }
        return flag;
    }

    function notify_cancel() {
        Swal.fire({
            icon: "warning",
            title: "Cảnh Báo!",
            text: "Không Có Mục Nào Được Chọn",
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
        }).then(function(result) {
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
                deleteItem.done(function(resp) {
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
        }).then(function(result) {
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
                restoreItem.done(function(resp) {
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
        }).then(function(result) {
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
                updateStatus.done(function(resp) {
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

    select.each(function() {
        var $this = $(this);
        $this.wrap('<div class="position-relative"></div>');
        $this
            .select2({
                dropdownAutoWidth: true,
                width: "100%",
                placeholder: "Vui Lòng Chọn",
                dropdownParent: $this.parent(),
            })
            .change(function() {
                $(this).valid();
            });
    });

    if (blogImageInput.length) {
        $(blogImageInput).on("change", function(e) {
            var reader = new FileReader(),
                files = e.target.files;
            reader.onload = function() {
                if (blogFeatureImage.length) {
                    blogFeatureImage.attr("src", reader.result);
                }
            };
            reader.readAsDataURL(files[0]);
        });
    }

    $(document).on("click", "#btn-delete", function() {
        var is_checked = isChecked();

        if (is_checked) {
            deleteAllItem($("#frmTbList").serialize());
        } else {
            notify_cancel();
        }
    });

    $(document).on("click", ".btn-status", function() {
        var is_checked = isChecked();
        var status = $(this).data("status");

        if (is_checked) {
            statusAllItem($("#frmTbList").serialize(), status);
        } else {
            notify_cancel();
        }
    });

    $(document).on("click", "#btn-restore", function() {
        var is_checked = isChecked();

        if (is_checked) {
            restoreAllItem($("#frmTbList").serialize());
        } else {
            notify_cancel();
        }
    });

    $(document).on("change", "#province_id", function() {
        var province_id = $(this).val();

        $.ajax({
            url: url_showDistrict,
            type: "post",
            async: true,
            cache: false,
            data: {
                province_id: province_id,
            },
        }).done(function(data) {
            data = jQuery.parseJSON(data);
            $("#district_id").html(data.getDistrict);
        });
    });
})(window);