<section class="product spad">
    <div class="container">
        <div class="row">
            <div class="col-lg-4 col-md-4">
                <div class="section-title">
                    <h4>Sản phẩm mới</h4>
                </div>
            </div>
            <div class="col-lg-8 col-md-8">
                <ul class="filter__controls">
                    <li class="active" data-filter="*">Tất cả sản phẩm</li>
                    @foreach ($menus as $item)
                        <li data-filter=".{{ $item->slug }}">{{ $item->name }}</li>
                    @endforeach

                </ul>
            </div>
        </div>
        <div class="row property__gallery">
            @foreach ($product as $item)
                @if ($item->category)
                    <div
                        class="col-lg-3 col-md-4 col-sm-6 mix {{ $item->category->slug }} {{ isset($item->category->children->slug) ? $item->category->children->slug : '' }}">
                        <div class="product__item">
                            @php
                                $image = json_decode($item->image);
                                
                            @endphp
                            <div class="product__item__pic set-bg"
                                data-setbg="{{ asset('storage') }}/{{$image[0]}}">
                                <div class="label new">New</div>
                                <ul class="product__hover">
                                    <li><a href="/product/{{$item->slug}}"><i class="fa fa-eye" aria-hidden="true"></i></a></li>
                                    <li><a><span class="icon_heart_alt add_cart" data-key="like" data-id="{{ $item->id }}"></span></a></li>
                                    <li class="add_cart" data-id="{{ $item->id }}" data-key="order"><a><span
                                                class="icon_bag_alt"></span></a></li>
                                </ul>
                            </div>
                            <div class="product__item__text">
                                <h6><a>{{ $item->name }}</a></h6>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>
    </div>
</section>
