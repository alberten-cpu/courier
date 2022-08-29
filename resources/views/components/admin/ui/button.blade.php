<button type="{{ $type }}" class="btn {{ $class }}" name="{{ $name }}" id="{{ $id }}"
        @if($disable) disabled @endif {{ $other }}>{{ __($btnName) }}</button>
