(function ($) {
"use strict";
var HT = {};

    HT.cart = () => {
        if ($(".add_cart").length) {
            $(document).on("click", ".add_cart", function () {
                var key = $(this).data("key");
                var id = $(this).data("id");
                updateCart(key, id, null);
            });
        }

        if ($("#change_number_cart").length) {
            var debounceTimeout; // Biến để lưu trữ timeout

            // Hàm debounce
            function debounce(func, delay) {
            clearTimeout(debounceTimeout);
            debounceTimeout = setTimeout(func, delay);
        }

        // Xử lý sự kiện input với debounce
        $(document).on("input", ".change_number_cart", function () {
            var key = $(this).data("key");
            var id = $(this).data("id");
            var quantity = $(this).val();

            // Gọi hàm debounce với hàm xử lý sự kiện và thời gian trễ
            debounce(function () {
            updateCart(key, id, quantity);
            }, 5000); // 5000ms = 5 seconds
        });

        // Xử lý sự kiện click với debounce
        $(document).on("click", ".qtybtn", function () {
            var key = $(this)
            .closest(".pro-qty")
            .find(".change_number_cart")
            .data("key");
            var id = $(this)
            .closest(".pro-qty")
            .find(".change_number_cart")
            .data("id");
            var quantity = $(this)
            .closest(".pro-qty")
            .find(".change_number_cart")
            .val();

            // Gọi hàm debounce với hàm xử lý sự kiện và thời gian trễ
            debounce(function () {
                updateCart(key, id, quantity);
            }, 5000); // 5000ms = 5 seconds
        });

        // Xử lý sự kiện click cho nút xóa với debounce
        $(document).on("click", ".cart__close", function () {
            var key = $(this).data("key");
            var id = $(this).data("id");

        // Gọi hàm debounce với hàm xử lý sự kiện và thời gian trễ
            debounce(function () {
            updateCart(key, id, null);
            }, 5000); // 5000ms = 5 seconds
        });
        }

        function updateCart(key, id, quantity = null) {
            $.ajax({
                type: "get",
                url: "/cart/" + id,
                data: {
                key: key,
                quantity: quantity,
            },
            dataType: "json",
            success: function (response) {
                    toastr.success(
                        "Cập nhật giỏ hàng thành công",
                        "Thành công"
                        );
                window.location.reload();
                },
                error: function (xhr, status, error) {
                console.error(xhr.responseText);
                },
                });
            }
        };

    $(document).ready(function () {
    HT.cart();
    });
})(jQuery);
