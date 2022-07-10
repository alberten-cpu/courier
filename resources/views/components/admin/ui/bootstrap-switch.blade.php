@push('styles')
    <link rel="stylesheet" href="{{asset('admin/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">
@endpush
<input type="checkbox" name="{{ $name }}" id="{{ $id }}" data-bootstrap-switch data-on-text="{{ __($onText) }}"
       data-off-text="{{ __($offText) }}"
       data-label-text="{{ __($label) }}" data-on-color="{{ $onColor }}" data-off-color="{{ $offColor }}"
       {{ Helper::isSelected(true,old($name),$value,'checkbox') }}
       @if($disable) disabled @endif @if($readonly) readonly @endif {{ $other }}>
@push('scripts')
    <script src="{{asset('admin/plugins/bootstrap-switch/js/bootstrap-switch.min.js')}}"></script>
    <script>
        $("input[data-bootstrap-switch]").each(function () {
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });
    </script>
@endpush
