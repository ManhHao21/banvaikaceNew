{{-- <a href="{{ url($menu->slug) }}" class="nav-link dropdown">{{ $menu->name }} @if ($menu->Parent_id)
        <i class="fa fa-angle-down float-right mt-1"></i>
    @endif
</a>
{{ $menu->id }}
@if ($menu->Parent_id()->count() > 0)

    <div class="dropdown-menu position-absolute bg-secondary border-0 rounded-0 w-100 m-0" >
            @foreach ($menu->Parent_id()->get() as $submenu)
                    @include('Fontend.component.chilrent', ['menu' => $submenu])
            @endforeach
    </div>
@endif --}}
