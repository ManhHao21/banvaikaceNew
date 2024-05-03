(function ($) {
    "use strict";
    var HT = {};
    HT.key = 0; // Define key as a property of HT object
    HT.start = () => {
        if ($(".fa-star-o").length > 0) {
            $(".fa-star-o, .fa-star").on("click", function (e) {
                e.preventDefault();
                HT.key = $(this).data("key"); // Update HT.key when a star is clicked
                if ($(this).hasClass("fa-star-o")) {
                    $(".fa-star").each(function () {
                        if ($(this).data("key") <= HT.key) {
                            $(this).removeClass("d-none"); // Show the stars
                            $(this)
                                .next(
                                    ".fa-star-o[data-key='" +
                                        $(this).data("key") +
                                        "']"
                                )
                                .addClass("d-none"); // Hide the empty stars
                        } else {
                            $(this).addClass("d-none"); // Hide the stars
                            $(this)
                                .prev(
                                    ".fa-star-o[data-key='" +
                                        $(this).data("key") +
                                        "']"
                                )
                                .removeClass("d-none"); // Show the empty stars
                        }
                    });
                } else if ($(this).hasClass("fa-star")) {
                    $(".fa-star-o").each(function () {
                        if ($(this).data("key") >= HT.key) {
                            $(this).removeClass("d-none"); // Show the stars
                            $(this)
                                .prev(
                                    ".fa-star[data-key='" +
                                        $(this).data("key") +
                                        "']"
                                )
                                .addClass("d-none"); // Hide the empty stars
                        } else {
                            $(this).addClass("d-none"); // Hide the stars
                            $(this)
                                .prev(
                                    ".fa-star-o[data-key='" +
                                        $(this).data("key") +
                                        "']"
                                )
                                .removeClass("d-none"); // Show the empty stars
                        }
                    });
                }
            });
        }
    };
    HT.submitComment = () => {
        if ($(".submit_comment").length > 0) {
            $(".submit_comment").on("click", function (e) {
                e.preventDefault(); // Ngăn chặn hành động mặc định của nút Gửi

                let id = $(this).data("id"); // Lấy giá trị data-id từ nút Gửi
                let form_comment = $("#form_comment_comment")[0]; // Lấy phần tử form

                // Tạo đối tượng FormData từ form
                let formData = new FormData(form_comment);
                console.log("====================================");
                console.log(formData);
                console.log("====================================");
                // Thêm CSRF token vào formData
                formData.append("_token", $("input[name='_token']").val());

                // Thêm rating vào formData (HT.key)
                formData.append("rating", HT.key);

                // Gửi AJAX request
                $.ajax({
                    type: "post",
                    url: "/ajax/comment/" + id,
                    data: formData,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                }).done(function (response) {
                    // Xử lý phản hồi từ server (response)
                    alert(response); // Hiển thị alert với phản hồi từ server
                });
            });
        }
    };

    $(document).ready(function () {
        HT.start();
        HT.submitComment();
    });
})(jQuery);
