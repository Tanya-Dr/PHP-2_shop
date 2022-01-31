function changeStatus() {
  $("#statusChange").remove();
  let id = $(event.target).data("id");
  $.ajax({
    type: "POST",
    url: "index.php?c=Admin&act=adminOrders",
    data: {
      status: $(event.target).val(),
      idOrder: $(event.target).data("id"),
    },
    success: function (answer) {
      let res = "";
      if (answer != 0) {
        res = "<p id = 'statusChange'>Data updated successfully</p>";
        $('.orders__text[data-id="' + id + '"]').text(answer);
        $('.orders__text[data-id="' + id + '"]').css("color", "red");
      } else {
        res = "<p id = 'statusChange'>" + answer["errText"] + "</p>";
      }
      $(res).insertBefore(".item__link");
    },
  });
}

function changeAccess() {
  $("#statusChange").remove();
  let id = $(event.target).data("id");
  $.ajax({
    type: "POST",
    url: "index.php?c=Admin&act=adminUsers",
    data: {
      admin: $(event.target).val(),
      id: $(event.target).data("id"),
    },
    success: function (answer) {
      let res = "<p id = 'statusChange'>" + answer + "</p>";
      $('.orders__text[data-id="' + id + '"]').css("color", "red");
      $(res).insertBefore(".item__link");
    },
  });
}

function showEditGallery() {
  event.preventDefault();
  let n = $(".good").length;
  let countGoods = $(event.target).data("count");
  $.ajax({
    type: "POST",
    url: "index.php?c=Admin&act=adminGoods",
    data: {
      lastId: $(".product__link").last().data("id"),
    },
    success: function (data) {
      $(".catalog_edit").append(data);
      if (n + 5 >= countGoods) {
        $(".item__btn_show").css("display", "none");
      }
    },
  });
}

$("#file-upload").change(function (el) {
  $(".input_photo").text(el.target.value.split("\\").pop());
});

$(".content__form").submit(function () {
  $("#answer").remove();
  event.preventDefault();
  let form_data = new FormData();
  form_data.append("photo", $("#file-upload").prop("files")[0]);
  form_data.append("title", $("#file-title").val());
  form_data.append("price", $("#file-price").val());
  form_data.append("shortInfo", $("#file-shortInfo").val());
  form_data.append("fullInfo", $("#file-fullInfo").val());
  if ($("#file-id")) {
    form_data.append("id", $("#file-id").val());
  }
  $.ajax({
    method: "POST",
    url: "index.php?c=Admin&act=editGoods",
    data: form_data,
    processData: false,
    contentType: false,
    success: function (answer) {
      if ($.isNumeric(answer)) {
        location.href = "index.php?c=Admin&act=editGoods&id=" + answer;
      } else {
        let res = "<p id = 'answer'>" + answer + "</p>";
        $(res).insertBefore(".form__button");
      }
    },
  });
});

function deleteGoods() {
  event.preventDefault();
  let id = $(event.target).data("id");
  $.ajax({
    type: "POST",
    url: "index.php?c=Admin&act=deleteGoods",
    data: {
      id: id,
    },
    success: function (answer) {
      let res = "<p class='form__err'>" + answer + "</p>";
      if (answer == "error") {
        $(res).insertAfter('.good[data-id="' + id + '"]');
      } else {
        $('.good[data-id="' + id + '"]').html(res);
      }
    },
  });
}
