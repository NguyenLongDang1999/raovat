<script>
var updateUserForm = $('#update-user-form'),
    emailForm = $('#email-form'),
    passwordForm = $('#password-form');

jQuery.validator.addMethod('valid_phone', function(value) {
    var regex =
        /^(0|\+84)(\s|\.)?((3[2-9])|(5[689])|(7[06-9])|(8[1-689])|(9[0-46-9]))(\d)(\s|\.)?(\d{3})(\s|\.)?(\d{3})$/;
    return value.trim().match(regex);
});

if (updateUserForm.length) {
    updateUserForm.validate({
        rules: {
            fullname: {
                required: true,
                maxlength: 30,
            },
            phone: {
                required: true,
                valid_phone: true
            },
            job: {
                maxlength: 50,
            },
            address: {
                maxlength: 255,
            },
        },
        messages: {
            fullname: {
                required: "Họ và tên không được bỏ trống.",
                maxlength: "Họ và tên không được vượt quá 30 ký tự.",
            },
            phone: {
                required: "Số điện thoại không được bỏ trống.",
                valid_phone: "Số điện thoại không hợp lệ.",
            },
            job: {
                maxlength: "Nghề nghiệp không được vượt quá 50 ký tự.",
            },
            address: {
                maxlength: "Địa chỉ không được vượt quá 255 ký tự.",
            },
        },
    });
}

if (passwordForm.length) {
    passwordForm.validate({
        rules: {
            password: {
                required: true,
                maxlength: 15,
                minlength: 8,
            },
            new_password: {
                required: true,
                maxlength: 15,
                minlength: 8,
            },
            new_password_confirm: {
                required: true,
                maxlength: 15,
                minlength: 8,
                equalTo: "#new_password"
            },
        },
        messages: {
            password: {
                required: "Password không được bỏ trống.",
                maxlength: "Password không được vượt quá 15 ký tự.",
                minlength: "Password phải có tối thiểu 8 ký tự.",
            },
            new_password: {
                required: "Password mới không được bỏ trống.",
                maxlength: "Password không được vượt quá 15 ký tự.",
                minlength: "Password phải có tối thiểu 8 ký tự.",
            },
            new_password_confirm: {
                required: "Nhập lại password mới không được bỏ trống.",
                maxlength: "Password không được vượt quá 15 ký tự.",
                minlength: "Password phải có tối thiểu 8 ký tự.",
                equalTo: "Xác nhận Password không trùng khớp. Vui lòng kiểm tra lại."
            },
        },
    });
}

if (emailForm.length) {
    emailForm.validate({
        rules: {
            email: {
                required: true,
                email: true,
                maxlength: 255,
                remote: {
                    url: "<?= route_to('user.auth.checkEmail'); ?>",
                    type: 'post',
                    dataType: 'json',
                    async: false,
                    cache: false,
                    dataFilter: function(data) {
                        let obj = eval('(' + data + ')');
                        return obj.valid;
                    },
                }
            },
            password: {
                required: true,
                maxlength: 15,
                minlength: 8,
            },
        },
        messages: {
            email: {
                required: "Email không được bỏ trống.",
                maxlength: "Email quá dài. Vui lòng kiểm tra lại.",
                email: "Email không đúng định dạng.",
                remote: "Email này đã tồn tại. Vui lòng nhập email khác."
            },
            password: {
                required: "Password không được bỏ trống.",
                maxlength: "Password không được vượt quá 15 ký tự.",
                minlength: "Password phải có tối thiểu 8 ký tự.",
            }
        },
    });
}

$('#tabMenu a').click(function(e) {
    e.preventDefault();
    $(this).tab('show');
    var id = $(this).attr("href");
    localStorage.setItem('activeTab', id);
});
$('#tabMenu a[href="' + localStorage.getItem('activeTab') + '"]').tab('show');
</script>