<!DOCTYPE html>
<html lang="zxx">

@include('frontend.components.head')

<body>
    <!-- Page Preloder -->
    <div id="preloder">
        <div class="loader"></div>
    </div>

    <!-- Offcanvas Menu Begin -->
    @include('frontend.components.menu-top')

    <!-- Offcanvas Menu End -->

    <!-- Header Section Begin -->
    @include('frontend.components.header')

    <!-- Header Section End -->

    <!-- Categories Section Begin -->
    @include('frontend.components.categories')

    <!-- Categories Section End -->

    <!-- Product Section Begin -->
    @include('frontend.components.product')

    <!-- Product Section End -->

    <!-- Banner Section Begin -->
    @include('frontend.components.banner')

    <!-- Banner Section End -->

    <!-- Trend Section Begin -->
    @include('frontend.components.trend')

    <!-- Trend Section End -->

    <!-- Discount Section Begin -->
    @include('frontend.components.discount')

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
