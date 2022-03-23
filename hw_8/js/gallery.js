function showGallery() {
  event.preventDefault();
  let n = $(".product").length;
  let countGoods = $(event.target).data("count");
  $.ajax({
    type: "POST",
    url: "index.php",
    data: {
      lastId: $(".product__link").last().data("id"),
      lastCountView: $(".product__link").last().data("count"),
    },
    success: function (data) {
      $(".catalog").append(data);
      if (n + 10 >= countGoods) {
        $(".item__btn").css("display", "none");
      }
    },
  });
}
