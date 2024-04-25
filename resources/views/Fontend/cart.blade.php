<!DOCTYPE html>
<html lang="en">
@include('Fontend.component.header')

<body> @include('Fontend.component.navProduct')
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shopping Cart</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shopping Cart</p>
            </div>
        </div>
    </div>

    <div class="container-fluid pt-5 wrapper-table">
        @include('Fontend.component.table')
    </div>
    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
    @include('Fontend.component.footer')
    @include('Fontend.component.script')
</body>
<script src="{{ asset('Fontend') }}/js/cart.js"></script>

</html>
