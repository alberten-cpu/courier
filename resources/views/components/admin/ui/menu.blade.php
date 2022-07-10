<li class="nav-item">
    <a href="{{ Helper::getRoute($route) }}"
       class="nav-link @if(request()->route()->getName()==$route) active @endif"
       target="{{ $target }}">
        <i class="nav-icon {{ $icon }}"></i>
        <p>
            {{ __($name) }}
            @if($new)
                <span class="right badge badge-danger">{{__('New')}}</span>
            @endif
            @if($count)
                <span class="badge badge-info right">{{ __($count) }}</span>
            @endif
        </p>
    </a>
</li>
