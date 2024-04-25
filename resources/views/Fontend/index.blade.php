<!DOCTYPE html>
<html lang="en">

@include('Fontend.component.header')

<body>
    @include('Fontend.component.nav')
    @include('Fontend.component.featured')
    {{-- @include('Fontend.component.category') --}}
    @include('Fontend.component.offer')
    @include('Fontend.component.Product', ['productNew' => $productNew])
    {{-- @include('Fontend.component.productNew', ['decodedValues' => $decodedValues]) --}}
    @include('Fontend.component.vendor')
    @include('Fontend.component.footer')

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('Fontend') }}/lib/easing/easing.min.js"></script>
    <script src="{{ asset('Fontend') }}/lib/owlcarousel/owl.carousel.min.js"></script>

    <!-- Contact Javascript File -->
    <script src="{{ asset('Fontend') }}/mail/jqBootstrapValidation.min.js"></script>
    <script src="{{ asset('Fontend') }}/mail/contact.js"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('Fontend') }}/js/main.js"></script>
</body>

</html>
