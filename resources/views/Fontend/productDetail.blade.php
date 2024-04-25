q<!DOCTYPE html>
<html lang="en">
@include('Fontend.component.header')

<body> @include('Fontend.component.navProduct')
    <div class="container-fluid bg-secondary mb-5">
        <div class="d-flex flex-column align-items-center justify-content-center" style="min-height: 300px">
            <h1 class="font-weight-semi-bold text-uppercase mb-3">Shop Detail</h1>
            <div class="d-inline-flex">
                <p class="m-0"><a href="">Home</a></p>
                <p class="m-0 px-2">-</p>
                <p class="m-0">Shop Detail</p>
            </div>
        </div>
    </div>

    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col-lg-5 pb-5">
                <div id="product-carousel" class="carousel slide" data-ride="carousel">
                    <div class="carousel-inner border">
                        <div class="carousel-item active" width="300px">
                            <img class="w-100 h-100" src="{{ asset('storage') . '/' . $product->image }}"
                                alt="Image">
                        </div>

                    </div>

                </div>
            </div>

            <div class="col-lg-7 pb-5">
                <h3 class="font-weight-semi-bold">{{ $product->name }}</h3>

                <h3 class="font-weight-semi-bold mb-4">{{ $product->price }}</h3>

                <div class="d-flex mb-3">
                    <ul>

                    </ul>
                    Chất liệu: @php
                        use App\Models\Material;

                        $materialIds = json_decode($product->material_id);

                        $materials = [];
                        if (isset($materialIds) && in_array($materialIds)) {
                            foreach ($materialIds as $value) {
                                $material = Material::find($value);

                                if ($material) {
                                    $materials[] = $material;
                                }
                            }
                        }
                    @endphp
                    @foreach ($materials as $material)
                        <div class="text-dark font-weight-medium mb-0 mr-3 btn btn-sm" style="align-items: center">


                            {{ $material->name }}<br>

                        </div>
                    @endforeach
                </div>

                <div class="d-flex align-items-center mb-4 pt-2 form-value">
                    <div class="input-group quantity mr-3" style="width: 130px;">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-minus">
                                <i class="fa fa-minus"></i>
                            </button>
                        </div>
                        <meta name="csrf-token" content="{{ csrf_token() }}" />
                        <input type="text" class="form-control bg-secondary text-center values" value="1">
                        <div class="input-group-btn">
                            <button class="btn btn-primary btn-plus">
                                <i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <input type="hidden" class="id" data-id="{{ $product->id }}">

                    </div>
                    <button class="btn btn-primary px-3 add-to-cart"><i class="fa fa-shopping-cart mr-1"></i> Add To
                        Cart</button>
                </div>
            </div>
        </div>
        <div class="row px-xl-5">
            <div class="col">
                <div class="nav nav-tabs justify-content-center border-secondary mb-4">
                    <a class="nav-item nav-link active" data-toggle="tab" href="#tab-pane-1">Mô tả sản phẩm</a>

                    <a class="nav-item nav-link" data-toggle="tab" href="#tab-pane-3">Reviews
                        ({{ $commentCount->count() }})</a>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tab-pane-1">
                        <h4 class="mb-3">Product Description</h4>{!! $product->description !!}

                    </div>
                    <div class="tab-pane fade" id="tab-pane-3">
                        <div class="row">
                            <div class="col-md-6 commentView">
                                <h4 class="mb-4"> {{ $commentCount->count() }} review for "{{ $product->name }}"</h4>
                                @foreach ($comments as $comment)
                                    <div class="media mb-4">
                                        <img src="{{ asset('Fontend') }}/img/user.jpg" alt="Image"
                                            class="img-fluid mr-3 mt-1" style="width: 45px;">
                                        <div class="media-body">
                                            <h6>{{ $comment->name }}</h6>
                                            <p>{{ $comment->content }}</p>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                            <div class="col-md-6">
                                <h4 class="mb-4">Leave a review</h4>
                                <small>Your email address will not be published. Required fields are marked *</small>
                                <form id="formcomment">
                                    <div class="form-group">
                                        <label for="message">Your Review *</label>
                                        <textarea id="message" cols="30" rows="5" class="form-control" name="content"></textarea>
                                        <p class="required" style="color:red;display:none;">Vui lòng nhập nội dung
                                            review</p>
                                    </div>
                                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                                    <meta name="csrf-token" content="{{ csrf_token() }}" />
                                    <div class="form-group">
                                        <label for="name">Your Name *</label>
                                        <input type="text" class="form-control" id="name" name="name">
                                        <p class="required" style="color:red;display:none;">Vui lòng nhập họ và tên
                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Your Email *</label>
                                        <input type="email" class="form-control" id="email" name="email">

                                        <p class=" required" style="color:red;display:none;">Vui lòng nhập email</p>
                                        <p class="email" style="color:red;display:none;">Vui lòng nhập đúng định dang
                                            email</p>
                                    </div>
                                    <button class="btn btn-primary px-3 comment">
                                        Để lại đánh giá của bạn
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Shop Detail End -->

    @if (isset($relatedProducts) && !empty($relatedProducts))
        <!-- Products Start -->
        <div class="container-fluid py-5">
            <div class="text-center mb-4">
                <h2 class="section-title px-5"><span class="px-2">Sản phẩm liên quan</span></h2>
            </div>
            <div class="row px-xl-5">
                <div class="col">
                    <div class="owl-carousel related-carousel">
                        @foreach ($relatedProducts as $relatedProduct)
                            <div class="card product-item border-0">
                                <div
                                    class="card-header product-img position-relative overflow-hidden bg-transparent border p-0">
                                    <img class="img-fluid w-100" src="{{ asset('storage') . '/' . $product->image }}"
                                        alt="{{ $product->name }}">
                                </div>
                                <div class="card-body border-left border-right text-center p-0 pt-4 pb-3">
                                    <h6 class="text-truncate mb-3">{{ $relatedProduct->name }}</h6>
                                    <div class="d-flex justify-content-center">
                                        <h6>{{ number_format($relatedProduct->price, 0, ',', '.') }} VNĐ</h6>
                                    </div>
                                </div>
                                <div class="card-footer d-flex justify-content-between bg-light border">
                                    <a href="" class="btn btn-sm text-dark p-0"><i
                                            class="fas fa-eye text-primary mr-1"></i>View Detail</a>
                                    <a href="" class="btn btn-sm text-dark p-0"><i
                                            class="fas fa-shopping-cart text-primary mr-1"></i>Add To Cart</a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif

    <a href="#" class="btn btn-primary back-to-top"><i class="fa fa-angle-double-up"></i></a>
    @include('Fontend.component.footer');
    @include('Fontend.component.script');


</body>


</html>
