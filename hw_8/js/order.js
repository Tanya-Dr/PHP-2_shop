$(".order__total").text(
  Number($("#total").val()) + Number($("input[name=delivery]:checked").val())
);

$(".order__input").click(function () {
  $(".order__total").text(
    Number($("#total").val()) + Number($("input[name=delivery]:checked").val())
  );
});

$(".order__form").submit(function () {
  event.preventDefault();
  $.ajax({
    method: "POST",
    url: "index.php?c=Order&act=createOrder",
    data: {
      address: $("#address").val(),
      tel: $("#tel").val(),
      delivery: $("input[name=delivery]:checked").val(),
      total: $("#total").val(),
    },
    success: function (data) {
      if (data == "ok") {
        location.href = "index.php?c=Order&act=ordersHistory";
      } else {
        $(".form__err").remove();
        $(data).insertBefore(".login__button");
      }
    },
  });
});

function showOrders() {
  event.preventDefault();
  let n = $(".order").length;
  let countOrders = $(event.target).data("count");
  $.ajax({
    type: "POST",
    url: "index.php?c=Order&act=ordersHistory",
    data: {
      lastDate: $(".order").last().data("date"),
    },
    success: function (data) {
      $(".history").append(data);
      if (n + 2 >= countOrders) {
        $(".item__btn").css("display", "none");
      }
    },
  });
}
