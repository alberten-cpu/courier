@push('styles')
    <!-- Select2 -->
    <link rel="stylesheet" href="{{asset('admin/plugins/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
@endpush
<div class="form-group">
    <label>{{__($label)}}</label>
    @if($multiple)
    <div class="select2-purple">
        @endif
    <select class="form-control select2 {{$addClass}}" @if($multiple)multiple="multiple" @endif name="{{$name}}"  id="{{$id}}" @if($required)required @endif @if($disable)disabled @endif style="width: 100%;">
        @if($default)
            <option value="" selected disabled>--Select--</option>
        @endif
        @forelse($options as $optionValue => $option)
                <option {{\Helper::isSelected($optionValue , $name , $value)}} value="{{$optionValue}}" >{{__($option)}}</option>
            @empty
            @endforelse
    </select>
        @if($multiple)
    </div>
    @endif
</div>
<!-- /.form-group -->
@push('scripts')
    <!-- Select2 -->
    <script src="{{asset('admin/plugins/select2/js/select2.full.min.js')}}"></script>
    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            //Initialize Select2 Elements
            $('.select2bs4').select2({
                theme: 'bootstrap4'
            })
        });
    </script>
@endpush
