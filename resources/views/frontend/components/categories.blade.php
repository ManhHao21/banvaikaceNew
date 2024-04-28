@if (isset($menus))
    <section class="categories">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 p-0">
                    <div class="categories__item categories__large__item set-bg"
                        data-setbg="{{ asset('storage') }}/{{ $menus[0]->image ?? '' }}">
                        <div class="categories__text">
                            <h1 style="color: #000;">{{ $menus[0]->name }}</h1>
                            <p style="color: #000;">{{$menus[0]->Product()->count() ? $menus[0]->Product()->count() : '' }} Sản phẩm</p>
                            <p style="color: #000;">{{ $menus[0]->meta_description }}</p>
                            <a style="color: #000;" href="#">Shop now</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row">
                        @foreach ($menus->slice(1) as $item)
                            <div class="col-lg-6 col-md-6 col-sm-6 p-0">
                                <div class="categories__item set-bg"
                                    data-setbg="{{ asset('storage') }}/{{ $item->image ?? '' }}">
                                    <div class="categories__text">
                                        <h4 style="color: #000;">{{ $item->name }}</h4>
                                        <p style="color: #000;">{{$item->Product()->count() ? $item->Product()->count() : '' }} Sản phẩm</p>
                                        <a style="color: #000;" href="{{ $item->link }}">Shop now</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
    </section>
@endif
