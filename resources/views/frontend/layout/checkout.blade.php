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
            <form action="{{ route('web.checkout.payment') }}" method="POST" class="checkout__form">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <h5>Chi tiết thanh toán</h5>
                        <div class="row">
                            <div class="col-lg-12 col-md-12 col-sm-12">
                                <div class="checkout__form__input">
                                    <p>Họ và tên <span>*</span></p>
                                    <input type="text" name='name' value="{{ Auth::user()->name ?? '' }}">
                                </div>
                            </div>
                            <div class="col-lg-12">

                                <div class="checkout__form__input">
                                    <p>Address <span>*</span></p>
                                    <input type="text" placeholder="Street Address" name="address"
                                        value="{{ Auth::user()->address ?? '' }}">
                                </div>
                                <div class="row">
                                    <div class="checkout__form__input col-lg-6 col-md-6 col-sm-6">
                                        <p>Tỉnh <span>*</span></p>
                                        <select name="province_id" class="form-control setupSelect2 province location"
                                            data-target="districts">
                                            <option value="0">[Chọn Thành Phố]</option>
                                            @if (isset($provindes))
                                                @foreach ($provindes as $province)
                                                    <option @if (Auth::user()->province_id == $province->code) selected @endif
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
                                    <input type="text" name="code">
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-6">

                                <div class="checkout__form__input">
                                    <p>Phone <span>*</span></p>
                                    <input type="text" name="phone" value="{{ Auth::user()->phone ?? '' }}">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-sm-6">
                                <div class="checkout__form__input">
                                    <p>Email <span>*</span></p>
                                    <input type="text" name="email" value="{{ Auth::user()->email ?? '' }}">
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="checkout__form__input">
                                    <p>Oder notes <span>*</span></p>
                                    <input type="text"
                                        placeholder="Note about your order, e.g, special noe for delivery"
                                        name="note">
                                </div>
                            </div>
                            <div class="checkout__order__widget">
                                <h5>Phương thức vận chuyển</h5>
                                <label for="o-acc">
                                    Thanh toán khi nhận hàng
                                    <input type="radio" id="o-acc" checked>
                                    <span class="checkmark"></span>
                                </label>
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

                                    <li>Phí chuyển <span>Tính sau</span></li>
                                </ul>
                                <ul>
                                    <?php
                                    $total = session()->get('total', []);
                                    ?>

                                    <li>Tổng tiền <span>{{ number_format($total, 0, ',', '.') }} VND</span></li>
                                </ul>
                            </div>

                            <div class="checkout__order__widget">
                                <h5>Phương thức thanh toán</h5>
                                <label for="payment_option">
                                    Thanh toán khi nhận hàng
                                    <input type="radio" id="payment_option" name="payment_option" value="cash">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="check-payment">
                                    Thanh toán VnPay
                                    <input type="radio" id="check-payment" name="payment_option" value="bank">
                                    <span class="checkmark"></span>
                                </label>
                                <button type="submit" class="site-btn">Đặt hàng</button>
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
