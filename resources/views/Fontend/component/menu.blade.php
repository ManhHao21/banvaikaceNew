<nav class="collapse show navbar navbar-vertical navbar-light align-items-start p-0 border border-top-0 border-bottom-0"
    id="navbar-vertical">
    <div class="navbar-nav w-100 overflow-hidden" style="height: 410px">
        @if ($menus)
            <div class="nav-item dropdown">
                @foreach ($menus as $menu)
                    @include('Fontend.component.chilrent', ['menu' => $menu])
                @endforeach
            </div>
        @endif
    </div>
</nav>
