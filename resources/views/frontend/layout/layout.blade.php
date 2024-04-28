@if (isset($cart))
    @if (count($cart) > 0)
        @foreach ($cart as $item)
            <tr>
                <td class="cart__product__item">
                    <img src="{{ asset('storage') }}/{{ $item['image'] }}" width="90px" height="90px" alt="">
                    <div class="cart__product__item__title">
                        <h6>{{ $item['name'] }}</h6>
                        <div class="rating">
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                            <i class="fa fa-star"></i>
                        </div>
                    </div>
                </td>
                <td class="cart__price">{{ $item['price'] }}</td>
                <td class="cart__quantity">
                    <div class="pro-qty">
                        <input type="text" value="{{ $item['quantity'] }}" class="change_number_cart"
                            id="change_number_cart" data-id="{{ $item['id'] }}" data-key="change-quantity">
                    </div>
                </td>

                <td class="cart__total">{{ number_format($item['quantity'] * $item['price'], 0, ',', '.') }} VNĐ</td>

                <td class="cart__close" data-id="{{ $item['id'] }}" data-key="close_row"><span
                        class="icon_close"></span></td>
            </tr>
        @endforeach
    @else
        <tr class="text-center"><td colspan="5">Không có sản phẩm nào trong giỏ hàng!!</td></tr>
    @endif
@endif
