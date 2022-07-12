<div class="form-group">
    <label for="{{ $id }}">{{ __($label) }} @if($required)
            <span class="text-danger">*</span>
        @endif</label>
    <textarea name="{{ $name }}"  class="form-control" rows="3" placeholder="Enter ..." @if($required) required
           @endif placeholder="{{ __($placeholder) }}">{{ $value  }}</textarea>
</div>
