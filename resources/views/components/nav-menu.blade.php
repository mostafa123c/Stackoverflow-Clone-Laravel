<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->

        @foreach($menuItems as $item)
            @if(!isset($item['ability']) || $user->can($item['ability'][0] , $item['ability'][1]))
        <li class="nav-item">
            <a href="{{ route($item['route'] )}}" class="nav-link">
                <i class="nav-icon {{ $item['icon'] }}"></i>
                <p>
                    {{ $item['title'] }}
{{--                    <span class="right badge badge-danger">New</span>--}}
                </p>
            </a>
        </li>
           @endif
        @endforeach
    </ul>
</nav>
