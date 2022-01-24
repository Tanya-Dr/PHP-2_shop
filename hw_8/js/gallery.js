function showGallery() {
  event.preventDefault();
  let n = $(".product").length;
  let countGoods = $(event.target).data("count");
  let lastId = $(".product__link").last().data("id");
  let lastCountView = $(".product__link").last().data("count");
  let str = "lastId=" + lastId + "&lastCountView=" + lastCountView;
  $.ajax({
    type: "POST",
    url: "index.php",
    data: str,
    success: function (data) {
      $(".catalog").append(data);
      if (n + 5 >= countGoods) {
        $(".item__btn").css("display", "none");
      }
    },
  });
}
