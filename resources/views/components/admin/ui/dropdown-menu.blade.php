<li class="nav-item @foreach($menus as $menu)
                        @if(request()->route()->getName()==$menu['route'] || str_contains(request()->route()->getName(),Helper::getFirstRoute($menu['route'])))
                        menu-open
                        @endif
                    @endforeach">
    <a href="#" class="nav-link
                    @foreach($menus as $menu)
                        @if(request()->route()->getName()==$menu['route'] || str_contains(request()->route()->getName(),Helper::getFirstRoute($menu['route'])))
                        active
                        @endif
                    @endforeach">
        <i class="nav-icon {{ $icon }}"></i>
        <p>
            {{ __($name) }}
            <i class="right fas fa-angle-left"></i>
        </p>
    </a>
    <ul class="nav nav-treeview">
        @forelse($menus as $menu)
            <li class="nav-item">
                <a href="{{ Helper::getRoute($menu['route']) }}"
                   class="nav-link @if(request()->route()->getName()==$menu['route'] || str_contains(request()->route()->getName(),Helper::getFirstRoute($menu['route']))) active @endif"
                   target="{{ Helper::getTarget($menu['target']) }}">
                    <i class="far fa-circle nav-icon"></i>
                    <p>{{ __($menu['label'])  }}</p>
                    @if($menu['new'])
                        <span class="right badge badge-danger">{{__('New')}}</span>
                    @endif
                    @if($menu['count'])
                        <span class="badge badge-info right">{{ __($menu['count']) }}</span>
                    @endif
                </a>
            </li>
        @empty
        @endforelse
    </ul>
</li>
