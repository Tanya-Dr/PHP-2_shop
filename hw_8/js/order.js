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
        $(data).insertBefore(".login__button");
      }
    },
  });
});
