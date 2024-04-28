jQuery(document).ready(function () {
  ImgUpload();
});

function ImgUpload() {
  var imgArray = [];

  $(".upload__inputfile").each(function () {
      $(this).on("change", function (e) {
          var imgWrap = $(this)
              .closest(".upload__box")
              .find(".upload__img-wrap");

          // Xóa hết các ảnh cũ trước khi thêm ảnh mới
          imgWrap.empty();

          var maxLength = parseInt($(this).attr("data-max_length"));
          var files = e.target.files;

          $.each(files, function (index, file) {
              if (!file.type.match("image.*")) {
                  return;
              }

              if (imgArray.length >= maxLength) {
                  return false;
              } else {
                  imgArray.push(file);

                  var reader = new FileReader();
                  reader.onload = function (e) {
                      var html =
                          "<div class='upload__img-box'><div style='background-image: url(" +
                          e.target.result +
                          ")' data-number='" +
                          $(".upload__img-close").length +
                          "' data-file='" +
                          file.name +
                          "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                      imgWrap.append(html);
                  };
                  reader.readAsDataURL(file);
              }
          });
      });
  });

  // Hàm xử lý sự kiện khi click vào nút close
  function close() {
      $("body").on("click", ".upload__img-close", function (e) {
          var file = $(this).parent().data("file");
          imgArray = imgArray.filter(function (imgFile) {
              return imgFile.name !== file;
          });
          $(this).parent().parent().remove();
      });
  }

  // Gọi hàm close để xử lý sự kiện khi click vào nút close
  close();
}
