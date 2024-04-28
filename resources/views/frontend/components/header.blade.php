<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3 col-lg-2">
                <div class="header__logo">
                    <a href="/"><img src="{{ asset('Frontend') }}/img/logo.png" alt=""></a>
                </div>
            </div>
            <div class="col-xl-6 col-lg-7">
                <nav class="header__menu">
                    <ul>
                        <li class="active"><a href="/">Trang chủ</a></li>
                        @foreach ($menus as $item)
                            <li><a href="{{ route('web.category', $item->slug) }}">{{ $item->name }}</a>
                                @if ($item->children->isNotEmpty())
                                    <ul class="dropdown">
                                        @foreach ($item->children()->where('publish', '1')->get() as $itemChild)
                                            <li><a
                                                    href="{{ route('web.category', $itemChild->slug) }}">{{ $itemChild->name }}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </li>
                        @endforeach


                        <li><a href="./blog.html">Bài viết</a></li>
                        <li><a href="./contact.html">Liên hệ</a></li>
                    </ul>
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__right">
                    <div class="header__right__auth">
                        <a href="#">Login</a>
                        <a href="#">Register</a>
                    </div>
                    <ul class="header__right__widget">
                        <li><span class="icon_search search-switch"></span></li>
                        <li><a href="#"><span class="icon_heart_alt"></span>
                                <div class="tip">2</div>
                            </a></li>
                        <li><a href="/cart-order"><span class="icon_bag_alt"></span>
                                <div class="tip">{{ $quantity ?? '' }}</div>
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="canvas__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
