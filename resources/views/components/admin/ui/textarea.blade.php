<div class="form-group">
    <label for="{{ $id }}">{{ __($label) }} @if($required)
            <span class="text-danger">*</span>
        @endif</label>
    <textarea name="{{ $name }}" id="{{ $id }}" class="form-control @error($name) is-invalid @enderror  {{ $addClass }}"
              rows="3" @if($required) required
              @endif placeholder="{{ __($placeholder) }}">{{ old($name,$value)  }}</textarea>
    @error($name)
    <span class="invalid-feedback" role="alert">
        <strong>{{ __($message) }}</strong>
    </span>
    @enderror
</div>
@push('scripts')
    {{--    Custom-JS --}}
@endpush
