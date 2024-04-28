<!DOCTYPE html>
<html lang="zxx">
@include('frontend.components.head')

<body>
    @include('frontend.components.menu-top')
    @include('frontend.components.header')
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="/"><i class="fa fa-home"></i> Trang chủ</a>
                        <span>Giỏ hàng</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Cart Section Begin -->
    <section class="shop-cart spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="shop__cart__table">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tên sản phẩm</th>
                                    <th>Giá tiền</th>
                                    <th>Số lượng</th>
                                    <th>Tổng tiền</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody class="cart_view">
                                @include('frontend.layout.layout', ['cart' => $cart])
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if (count($cart) > 0)
                @php
                    $sumQuantity = 0;
                    $totalMoney = 0;
                    $totalSeller = 0;
                    $total = 0;
                    $sell = 0;
                    foreach ($cart as $item) {
                        $sumQuantity += $item['quantity'];
                        $totalMoney += $item['price'] * $item['quantity'];
                    }

                    if ($sumQuantity >= 2000) {
                        $sell = 20 / 100;
                        $totalSeller = $totalMoney * $sell;
                    } elseif ($sumQuantity >= 1000) {
                        $sell = 15 / 100;
                        $totalSeller = $totalMoney * $sell;
                    } elseif ($sumQuantity >= 500) {
                        $sell = 10 / 100;
                        $totalSeller = $totalMoney * $sell;
                    }

                    $total = $totalMoney - $totalSeller;
                    session()->get('total', []);
                    session()->put('total', $total);
                @endphp

            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="cart__btn">
                        <a href="#">Tiếp tục mua sắm</a>
                    </div>
                </div>
            </div>
            <div class="row justify-content-end">
                <div class="col-lg-5 offset-lg-2">
                    <div class="cart__total__procced">
                        <h6>Tổng tiền</h6>
                        <ul>
                            <li>Tổng phụ <span>{{ number_format($totalMoney, 0, ',', '.') }} VNĐ</span></li>
                            @if($sell != 0)
                            <li>Giảm giá (chiết khấu {{ $sell * 100 }}%) <span> -
                                    {{ number_format($totalSeller, 0, ',', '.') }} VNĐ</span></li>
                            @endif
                            <li>Tổng tiền <span>{{ number_format($total, 0, ',', '.') }} VNĐ</span></li>
                        </ul>
                        <a href="/checkout" class="primary-btn">Thanh toán</a>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </section>
    <!-- Shop Cart Section End -->

    <!-- Discount Section End -->

    <!-- Services Section Begin -->
    @include('frontend.components.services')

    <!-- Services Section End -->

    <!-- Footer Section Begin -->
    @include('frontend.components.footer')

    <!-- Footer Section End -->
    <!-- Js Plugins -->
    @include('frontend.components.script')
</body>

</html>
