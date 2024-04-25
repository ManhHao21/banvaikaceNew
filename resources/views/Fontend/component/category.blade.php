@php
    use App\Models\Categories;
@endphp

@if ($decodedValuesCatelog && isset($decodedValuesCatelog['category_id']))
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            @foreach ($decodedValuesCatelog['category_id'] as $item)
                @php
                    echo $item;
                    $Category = Categories::find($item);
                @endphp
                @if ($Category)
                    <div class="col-lg-4 col-md-6 pb-1">
                        <div class="cat-item d-flex flex-column border mb-4" style="padding: 30px;">
                            <p class="text-right">{{$Category->Product()->count()}} Sản phẩm</p>
                            <a href="{{ url($Category->slug) }}" class="cat-img position-relative overflow-hidden mb-3">
                                <img class="img-fluid" src="{{ asset('Storage') . '/' . $Category->image }} "
                                    alt="">
                            </a>
                            <h5 class="font-weight-semi-bold m-0">{{ $Category->name }}</h5>
                        </div>
                    </div>
                @endif
            @endforeach

        </div>
    </div>
@endif
