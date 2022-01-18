function showGallery() {
  event.preventDefault();
  let n = $(".product").length;
  let countGoods = $(event.target).data("count");
  let lastId = $(".product__link").last().data("id");
  let str = "lastId=" + lastId;
  $.ajax({
    type: "POST",
    url: "index.php",
    data: str,
    success: function (data) {
      console.log(data);
      $(".catalog").append(data);
      if (n + 5 >= countGoods) {
        $(".item__btn").css("display", "none");
      }
    },
  });
}
