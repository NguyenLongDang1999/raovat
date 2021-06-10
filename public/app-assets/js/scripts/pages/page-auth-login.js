$(function () {
  "use strict";

  var pageLoginForm = $(".auth-login-form");

  if (pageLoginForm.length) {
    pageLoginForm.validate({
      rules: {
        login: {
          required: true,
          email: true,
        },
        password: {
          required: true,
        },
      },
    });
  }
});
