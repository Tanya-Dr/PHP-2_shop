$(".login__form").submit(function () {
  event.preventDefault();
  $.ajax({
    method: "POST",
    url: "index.php?c=User&act=login",
    data: {
      email: $("#email").val(),
      pass: $("#pass").val(),
    },
    success: function (data) {
      if (data == "ok") {
        location.href = "index.php?c=User&act=profile";
      } else {
        $(".form__err").remove();
        $(data).insertBefore(".login__button");
      }
    },
  });
});

$(".signup__form").submit(function () {
  event.preventDefault();
  $.ajax({
    method: "POST",
    url: "index.php?c=User&act=signup",
    data: {
      email: $("#email").val(),
      nickname: $("#nickname").val(),
      pass: $("#pass").val(),
      passConfirm: $("#passConfirm").val(),
    },
    success: function (data) {
      if (data == "ok") {
        location.href = "index.php?c=User&act=profile";
      } else {
        $(".form__err").remove();
        $(data).insertBefore(".login__button");
      }
    },
  });
});
