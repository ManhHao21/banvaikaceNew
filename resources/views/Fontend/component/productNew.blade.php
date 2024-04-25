@php
    use App\Models\Product;
@endphp
@section('style')
    <style>
        .text {
            display:-webkit-box;
            -webkit-line-clamp:2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            word-break: break-word;
            padding: 0 20px
        }
    </style>
@endsection
@if (isset($decodedValues))
    <div class="container-fluid pt-5">
        <div class="text-center mb-4">
            <h2 class="section-title px-5"><span class="px-2">Sản phẩm nổi bật</span></h2>
        </div>
        <div class="row px-xl-5 pb-3">
            @foreach ($decodedValues['product_selling'] as $item)
                @php

                    $product = Product::find($item);

                @endphp
                @if ($product)
                    <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                        <div class="card product-item border-0 mb-4">
                            <div
                                class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                <img class="img-fluid w-100"
                                    src="{{ asset('storage') .'/' . $product->image }}"
                                    alt="{{ $product->name }}">
                            </div>
                            <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                <h6 class="text-truncate mb-3 text">{{ $product->name }}</h6>
                                <div class="d-flex justify-content-center">
                                    <h6>{{ $product->price }}</h6>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-between bg-light border">
                                <a href="{{route('web.productDetail', $product->slug)}}" class="btn btn-sm text-dark p-0"><i
                                        class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                <a href="" class="btn btn-sm text-dark p-0"><i
                                        class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
@endif
