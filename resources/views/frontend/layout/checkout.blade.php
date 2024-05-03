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
    <section class="checkout spad">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    @if (!Auth::check())
                        <h6 class="coupon__link"><span class="icon_tag_alt"></span> <a href="/login">Đăng nhập tài
                                khoản?</a>
                            Login</h6>
                    @endif
                </div>
            </div>
            <form action="#" class="checkout__form">
                <div class="row">
                    <div class="col-lg-8">
                        <h5>Chi tiết thanh toán</h5>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="checkout__form__input">
                                    <p>Họ và tên <span>*</span></p>
                                    <input type="text" name>
                                </div>
                            </div>
                            <div class="col-lg-12">

                                <div class="checkout__form__input">
                                    <p>Address <span>*</span></p>
                                    <input type="text" placeholder="Street Address">
                                    <input type="text" placeholder="Apartment. suite, unite ect ( optinal )">
                                </div>
                                <div class="row">
                                    <div class="checkout__form__input col-lg-6 col-md-6 col-sm-6">
                                        <p>Tỉnh <span>*</span></p>
                                        <select name="province_id" class="form-control setupSelect2 province location"
                                            data-target="districts">
                                            <option value="0">[Chọn Thành Phố]</option>
                                            @if (isset($provindes))
                                                @foreach ($provindes as $province)
                                                    <option @if (old('province_id') == $province->code) selected @endif
                                                        value="{{ $province->code }}">
                                                        {{ $province->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="checkout__form__input col-lg-6 col-md-6 col-sm-6 ">
                                        <p>Huyên <span>*</span></p>
                                        <select name="district_id" class="form-control districts setupSelect2 location"
                                            data-target="wards">
                                            <option value="0">[Chọn Quận/Huyện]</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="checkout__form__input">
                                    <p>Xã <span>*</span></p>
                                    <select name="ward_id" class="form-control setupSelect2 wards">
                                        <option value="0">[Chọn Phường/Xã]</option>
                                    </select>
                                </div>

                                <div class="checkout__form__input">
                                    <p>Postcode/Zip <span>*</span></p>
                                    <input type="text">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">

                                <div class="checkout__form__input">
                                    <p>Phone <span>*</span></p>
                                    <input type="text">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Email <span>*</span></p>
                                    <input type="text">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="checkout__order">
                            <h5>Sản phẩm đặt hàng</h5>
                            <div class="checkout__order__product">
                                <ul>
                                    <li>
                                        <span class="top__text">Sản phẩm</span>
                                        <span class="top__text__right">Tổng tiền</span>
                                    </li>
                                    @if (isset($cart))
                                        @foreach ($cart as $key => $item)
                                            <li>0{{ $key }}. {{ $item['name'] }}
                                                <span>{{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }}
                                                    VND</span>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                            </div>
                            <div class="checkout__order__total">
                                <ul>
                                    <?php
                                    $total = session()->get('total', []);
                                    ?>

                                    <li>Tổng tiền <span>{{ number_format($total, 0, ',', '.') }} VND</span></li>
                                </ul>
                            </div>
                            <div class="checkout__order__widget">
                                <label for="o-acc">
                                    Create an acount?
                                    <input type="checkbox" id="o-acc">
                                    <span class="checkmark"></span>
                                </label>
                                <p>Create am acount by entering the information below. If you are a returing
                                    customer
                                    login at the top of the page.</p>
                                <label for="check-payment">
                                    Cheque payment
                                    <input type="checkbox" id="check-payment">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="paypal">
                                    PayPal
                                    <input type="checkbox" id="paypal">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                            <button type="submit" class="site-btn">Place oder</button>
                        </div>
                    </div>
                </div>
            </form>
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
