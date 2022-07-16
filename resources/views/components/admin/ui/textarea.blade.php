<div class="form-group">
    <label for="{{ $id }}">{{ __($label) }} @if($required)
            <span class="text-danger">*</span>
        @endif</label>
    <textarea name="{{ $name }}" id="{{ $id }}" class="form-control" rows="3" @if($required) required
              @endif placeholder="{{ __($placeholder) }}">{{ old($name,$value)  }}</textarea>
</div>
@push('scripts')
    {{--    Custom-JS --}}
@endpush
