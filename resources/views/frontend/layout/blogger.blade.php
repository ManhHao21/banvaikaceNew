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
                        <span>bài viết</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Shop Cart Section Begin -->
    <section class="blog spad">
        <div class="container">
            <div class="row">
                @foreach ($blog as $key => $item)
                    <a class="col-lg-4 col-md-4 col-sm-6">
                        <div class="blog__item">
                            <div class="blog__item__pic {{ $key == 0 ? 'large__item' : '' }} set-bg"
                                data-setbg="img/blog/blog-1.jpg"></div>
                            <div class="blog__item__text">
                                <h6><a href="#">No Bad Blood! The Reason Why Tamr Judge Finally Made Up
                                        With...</a>
                                </h6>
                                <ul>
                                    <li>by <span>Ema Timahe</span></li>
                                    <li>Seb 17, 2019</li>
                                </ul>
                            </div>
                        </div>
                    </a>
                @endforeach
                <div class="col-lg-12 text-center">
                    <a href="#" class="primary-btn load-btn">Load more posts</a>
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
