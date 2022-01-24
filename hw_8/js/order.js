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
  // let fd = new FormData();
  // fd.append("address", $("#address").val());
  // fd.append("tel", $("#tel").val());
  // fd.append("delivery", $("input[name=delivery]:checked").val());
  // fd.append("total", $("#total").val());
  // let str =
  //   "address=" +
  //   $("#address").val() +
  //   "&tel=" +
  //   $("#tel").val() +
  //   "&delivery=" +
  //   $("input[name=delivery]:checked").val() +
  //   "&total=" +
  //   $("#total").val();

  // $.ajax({
  //   url: "index.php?c=Order&act=createOrder",
  //   data: fd,
  //   type: "POST",
  //   processData: false,
  //   contentType: false,
  //   success: function (data) {
  //     // $(".order__form").append(data);
  //     console.log(data);
  //   },
  // });

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
        location.href = "index.php?page=orderHistory";
      } else {
        $(".order__form").append(data);
      }
    },
  });
});
