@push('styles')
    @once
        <!-- Select2 -->
        <link rel="stylesheet" href="{{asset('admin/plugins/select2/css/select2.min.css')}}">
        <link rel="stylesheet" href="{{asset('admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
        <style>
            .select2-selection__rendered {
                line-height: 31px !important;
            }

            .select2-container .select2-selection--single {
                height: 38px !important;
            }

            .select2-selection__arrow {
                height: 38px !important;
            }
        </style>
    @endonce
@endpush
<div class="form-group">
    <label>{{__($label)}} @if($required)
            <span class="text-danger">*</span>
        @endif</label>
    @if($multiple)
        <div class="select2-purple">
            @endif
            <select class="form-control select2 {{$addClass}}" @if($multiple)multiple="multiple" @endif name="{{$name}}"
                    id="{{$id}}" @if($required)required @endif @if($disable)disabled
                    @endif style="width: 100%;" style="width: 100%;">
                @if($default)
                    <option value="" selected disabled>--Select--</option>
                @endif
                @if(is_array($options))
                    @forelse($options as $optionValue => $option)
                        <option
                            {{Helper::isSelected($optionValue , old($name,$value) , $value)}} value="{{$optionValue}}">{{__($option)}}</option>
                    @empty
                    @endforelse
                @endif
            </select>
            @if($multiple)
        </div>
    @endif
</div>
<!-- /.form-group -->
@push('scripts')
    @once
        <!-- Select2 -->
        <script src="{{asset('admin/plugins/select2/js/select2.full.min.js')}}"></script>
    @endonce
    <script>
        $(function () {
            //Initialize Select2 Elements
            @if(!is_array($options))
            $('.{{$addClass}}').select2({
                ajax: {
                    url: "{{ Helper::getRoute($options) }}",
                    type: "get",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            search: params.term // search term
                        };
                    },
                    processResults: function (response) {
                        return {
                            results: response
                        };
                    },
                    cache: true
                },
                initSelection: function (element, callback) {
                    let id = null;
                    @if(old($name,$value))
                        id = {{old($name,$value)}};
                    @endif
                    if (id) {
                        $.ajax("{{ Helper::getRoute($options) }}", {
                            data: {id: id},
                            dataType: "json"
                        }).done(function (data) {
                            callback(data);
                        });
                    }
                }
            });
            @else
            $('.{{$addClass}}').select2();
            @endif
            //Initialize Select2 Elements
            // $('.select2bs4').select2({
            //     theme: 'bootstrap4'
            // })
        });
    </script>
@endpush
