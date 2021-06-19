<script>
    var editor = "#blog-editor-container .editor";
    var url_showDistrict = "<?= route_to('user.post.showDistrict') ?>";
    var getStartDate = moment();
    var getEndDate = 7;
    var postForm = $('#post-form');

    $(".input-images-1").imageUploader({
        maxFiles: 5,
        maxSize: 10 * 1024 * 1024,
        extensions: [".jpg", ".jpeg", ".png", ".gif"],
    });

    $(".buttonClass").daterangepicker({
        ranges: {
            "Gói 7 Ngày": [moment(), moment().add(7, "days")],
            "Gói 30 Ngày": [moment(), moment().add(30, "days")],
            "Gói 60 Ngày": [moment(), moment().add(60, "days")],
            "Gói 90 Ngày": [moment(), moment().add(90, "days")],
        },
        startDate: getStartDate,
        endDate: moment().add(getEndDate, "days"),
        alwaysShowCalendars: false,
        showCustomRangeLabel: false,
        drops: "down",
        locale: {
            format: "DD/MM/YYYY",
        },
    });

    var Font = Quill.import("formats/font");
    Font.whitelist = ["sofia", "slabo", "roboto", "inconsolata", "ubuntu"];
    Quill.register(Font, true);

    var blogEditor = new Quill(editor, {
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
                ["link"],
                ["clean"],
            ],
        },
        theme: "snow",
    });

    blogEditor.on('text-change', function(delta, oldDelta, source) {
        document.getElementById("quill_html").value = blogEditor.root.innerHTML;
    });

    if (postForm.length) {
        postForm.validate({
            ignore: ":hidden, [contenteditable='true']:not([name])",
            rules: {
                name: {
                    required: true,
                    maxlength: 70,
                },
                cat_id: {
                    required: true,
                },
                is_type: {
                    required: true,
                },
                province_id: {
                    required: true,
                },
                district_id: {
                    required: true,
                },
                price: {
                    required: true,
                    number: true
                },
                video: {
                    url: true,
                    maxlength: 255,
                },
                video_description: {
                    maxlength: 255,
                }
            },
            messages: {
                name: {
                    required: "Tiêu đề không được bỏ trống.",
                    maxlength: "Tiêu đề không được vượt quá 70 ký tự.",
                },
                cat_id: {
                    required: "Danh mục không được bỏ trống.",
                },
                is_type: {
                    required: "Hình thức không được bỏ trống.",
                },
                province_id: {
                    required: "Tỉnh/Thành Phố không được bỏ trống.",
                },
                district_id: {
                    required: "Quận/Huyện không được bỏ trống.",
                },
                price: {
                    required: "Giá cả không được bỏ trống.",
                    number: "Giá không hợp lệ."
                },
                video: {
                    url: "Link Youtube phải là một đường dẫn hợp lệ",
                    maxlength: "Link Youtube không được vượt quá 255 ký tự.",
                },
                video_description: {
                    maxlength: "Mô tả Video không được vượt quá 255 ký tự.",
                },
            },
        });
    }
</script>