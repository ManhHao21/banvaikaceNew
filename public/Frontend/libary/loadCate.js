(function ($) {
    "use strict";
    var HT = {};

    HT.loadCate = () => {
        var slug = $(".shop").data("slug");
        console.log("====================================");
        console.log(slug);
        console.log("====================================");
        $.ajax({
            type: "get",
            url: "/load/category/" + slug,
            data: "data",
            dataType: "json",
            success: function (response) {
                console.log("====================================");
                console.log(response.product);
                console.log("====================================");
                let html = "";
                if (response.product.length > 0) {
                    response.product.forEach((product) => {
                        // Convert image string to an array and get the first element
                        var images = JSON.parse(product.image);
                        var firstImage = images[0];

                        console.log("====================================");
                        console.log(product);
                        console.log("====================================");

                        // Format price to VND
                        var formattedPrice = formatCurrency(product.price);

                        html += `
                            <div class="col-lg-4 col-md-6">
                                <div class="product__item">
                                    <div class="product__item__pic set-bg" data-setbg="http://banvaikacenew.test:81/storage/${firstImage}" style="background-image: url(http://banvaikacenew.test:81/storage/${firstImage});">
                                        <ul class="product__hover">
                                            <li><a href="${firstImage}" class="image-popup"><span class="arrow_expand"></span></a></li>
                                            <li><a href="#"><span class="icon_heart_alt"></span></a></li>
                                            <li><a><span class="icon_bag_alt add_cart"></span></a></li>
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
                            </div>`;
                    });
                }
                // Append the generated HTML to the container in your DOM
                $(".product-list-container").html(html);
            },
        });
    };

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
