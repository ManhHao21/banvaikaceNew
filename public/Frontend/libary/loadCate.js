(function ($) {
    "use strict";
    var HT = {};

    HT.loadCate = () => {
        var slug = $(".shop").data("slug");
        $('.btn-fillter').on('click', function(e) {
            e.preventDefault();
            let min = $('#minamount').val().replaceAll('.', '').replace('₫', '');
            let max = $('#maxamount').val().replaceAll('.', '').replace('₫', '');
            let fillterPrice = {
                'min': min,
                'max': max
            }
            loadAjax(fillterPrice)
        })
        loadAjax();
        function loadAjax(filter = null) {
            $.ajax({
                type: "get",
                url: "/load/category/" + slug,
                data: filter,
                dataType: "json",
                success: function (response) {
                    let html = "";
                    if (response.product.product.length > 0) {
                        response.product.product.forEach((product) => {
                            // Convert image string to an array and get the first element
                            var images = JSON.parse(product.image);
                            var firstImage = images[0];
    
                            console.log("====================================");
                            console.log(product);
                            console.log("====================================");
    
                            // Format price to VND
                            var formattedPrice = formatCurrency(product.price);
    
                            html += `
                                <a class="col-lg-4 col-md-6">
                                    <div class="product__item">
                                        <div class="product__item__pic set-bg" data-setbg="http://banvaikacenew.test:81/storage/${firstImage}" style="background-image: url(http://banvaikacenew.test:81/storage/${firstImage});">
                                            <ul class="product__hover">
                                            <li><a href="/product/${product.name}" class="image-popup"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                                                <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                                <li class="add_cart"  data-id="${product.id}" data-key="order"><a><span class="icon_bag_alt"></span></a></li>
                                            </ul>
                                        </div>
                                        <div class="product__item__text">
                                            <h6><a href="#">${product.name}</a></h6>
                                            <div class="rating">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                            <div class="product__price">${formattedPrice}</div>
                                        </div>
                                    </div>
                                </a>`;
    
                                
                        });
                    }else if(response.product.product.length < 0){
                        html += 'Không có sản phẩm nào'
                    }
                    // Append the generated HTML to the container in your DOM
                    $(".product-list-container").html(html);
                },
            });
        }
        
    };

    // Bắt sự kiện khi nhấn vào nút "add_cart"
    $(document).on("click", ".add_cart", function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var key = $(this).data("key");
        updateCart(key, id, null);
    });

    // Hàm cập nhật giỏ hàng
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
                toastr.success("Cập nhật giỏ hàng thành công", "Thành công");
            },
            error: function (xhr, status, error) {
                console.error(xhr.responseText);
            },
        });
    }

    // Chuyển đổi giá sang định dạng tiền tệ VND
    function formatCurrency(price) {
        var formatter = new Intl.NumberFormat('vi-VN', {
            style: 'currency',
            currency: 'VND'
        });
        return formatter.format(price);
    }

    $(document).ready(function () {
        HT.loadCate();
    });
})(jQuery);
