function addToCart() {
  event.preventDefault();
  let id = $(event.target).data("id");
  let str = "id=" + id;
  $.ajax({
    type: "POST",
    url: "index.php?c=Cart&act=addToCart",
    data: str,
    success: function (data) {
      if (data == "not authorized") {
        data =
          "<a class='modal__link' href='index.php?c=User&act=login'>Login</a> to shop.";
      }
      $("#myModal_p").html(data);
      $("#myModal").css({ display: "block" });
    },
  });
}

$(".close").click(function () {
  $("#myModal").css({ display: "none" });
});
$(window).click(function (e) {
  $("#myModal").css({ display: "none" });
});

function deleteFromCart() {
  let str = "id=" + $(event.target).data("id");
  $.ajax({
    type: "POST",
    url: "index.php?c=Cart&act=deleteFromCart",
    data: str,
    success: function (answer) {
      $(".content").html(answer);
    },
  });
}

function clearCart() {
  event.preventDefault();
  $.ajax({
    type: "POST",
    url: "index.php?c=Cart&act=clearCart",
    success: function (answer) {
      $(".content").html(answer);
    },
  });
}

function changeQuantity() {
  let str =
    "count=" + $(event.target).val() + "&id=" + $(event.target).data("id");
  $.ajax({
    type: "POST",
    url: "index.php?c=Cart&act=changeCart",
    data: str,
    success: function (answer) {
      $(".content").html(answer);
    },
  });
}
