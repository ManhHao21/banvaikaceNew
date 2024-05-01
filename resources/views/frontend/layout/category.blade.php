<!DOCTYPE html>
<html lang="zxx">
@include('frontend.components.head')
@php
    $slug = request()->segment(2, 'default');
@endphp

<body>
    @include('frontend.components.menu-top')
    @include('frontend.components.header')
    <div class="breadcrumb-option">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb__links">
                        <a href="/"><i class="fa fa-home"></i> Trang chủ</a>
                        <span>Danh mục sản phẩm</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Cart Section Begin -->
    <section class="shop spad" data-slug="{{ $slug }}">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-3">
                    <div class="shop__sidebar">
                        <div class="sidebar__categories">
                            <div class="section-title">
                                <h4>Danh mục</h4>
                            </div>
                            <div class="categories__accordion">
                                <div class="accordion" id="accordionExample">
                                    @foreach ($menus as $key => $item)
                                        <div class="card">
                                            <div class="card-heading">
                                                <a data-toggle="collapse"
                                                    data-target="#collapse{{ $key }}">{{ $item['name'] }}</a>
                                            </div>
                                            @if ($item->children->isNotEmpty())
                                                <div id="collapse{{ $key }}" class="collapse "
                                                    data-parent="#accordionExample">
                                                    <div class="card-body">
                                                        <ul>
                                                            @foreach ($item->children->where('publish', '1') as $itemChild)
                                                                <li><a
                                                                        href="/category/{{ $itemChild->slug }}">{{ $itemChild->name }}</a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach


                                </div>
                            </div>
                        </div>
                        <div class="sidebar__filter">
                            <div class="section-title">
                                <h4>Giá tiền</h4>
                            </div>
                            <div class="filter-range-wrap">
                                <div class="price-range ui-slider ui-corner-all ui-slider-horizontal ui-widget ui-widget-content"
                                    data-min="0" data-max="100"></div>
                                <div class="range-slider">
                                    <span>Giá tiền</span>
                                    <div class="price-input d-flex">
                                        <input type="text" id="minamount" style="width: 100px;">
                                        <p>-</p>
                                        <input type="text" id="maxamount">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <a href="#" class="btn btn-primary d-flex justify-content-end btn-fillter"
                            style="width:fit-content">Filter</a>

                        <div class="sidebar__sizes">
                            <div class="section-title">
                                <h4>Shop by size</h4>
                            </div>
                            <div class="size__list">
                                <label for="xxs">
                                    xxs
                                    <input type="checkbox" id="xxs">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="xs">
                                    xs
                                    <input type="checkbox" id="xs">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="xss">
                                    xs-s
                                    <input type="checkbox" id="xss">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="s">
                                    s
                                    <input type="checkbox" id="s">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="m">
                                    m
                                    <input type="checkbox" id="m">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="ml">
                                    m-l
                                    <input type="checkbox" id="ml">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="l">
                                    l
                                    <input type="checkbox" id="l">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="xl">
                                    xl
                                    <input type="checkbox" id="xl">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                        <div class="sidebar__color">
                            <div class="section-title">
                                <h4>Shop by size</h4>
                            </div>
                            <div class="size__list color__list">
                                <label for="black">
                                    Blacks
                                    <input type="checkbox" id="black">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="whites">
                                    Whites
                                    <input type="checkbox" id="whites">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="reds">
                                    Reds
                                    <input type="checkbox" id="reds">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="greys">
                                    Greys
                                    <input type="checkbox" id="greys">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="blues">
                                    Blues
                                    <input type="checkbox" id="blues">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="beige">
                                    Beige Tones
                                    <input type="checkbox" id="beige">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="greens">
                                    Greens
                                    <input type="checkbox" id="greens">
                                    <span class="checkmark"></span>
                                </label>
                                <label for="yellows">
                                    Yellows
                                    <input type="checkbox" id="yellows">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9">
                    <div class="row product-list-container">

                    </div>
                    <div class="col-lg-12 text-center">
                        <div class="pagination__option">
                            
                        </div>
                    </div>
                </div>
            </div>
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
