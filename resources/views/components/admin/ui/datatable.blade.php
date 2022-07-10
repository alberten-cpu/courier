@push('styles')
    {{-- Custom Style --}}
    <!-- DataTables -->
    <link rel="stylesheet" href="{{asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
@endpush

<!-- Content Header (Page header) -->
<div class="content-header">
    {{ $breadcrumb }}
    <!-- /.content-header -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">{{ $title }}</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            {!! $dataTable->table() !!}
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.content -->
    {{--    <!-- Modal start -->--}}
    {{--    <div class="modal" tabindex="-1" role="dialog" id="{{ $modalId }}">--}}
    {{--        <div class="modal-dialog" role="document">--}}
    {{--            <div class="modal-content">--}}
    {{--                <div class="modal-header">--}}
    {{--                    <h5 class="modal-title">{{ __('Delete row') }}</h5>--}}
    {{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
    {{--                        <span aria-hidden="true">&times;</span>--}}
    {{--                    </button>--}}
    {{--                </div>--}}
    {{--                <div class="modal-body">--}}
    {{--                    <form method="POST" id="modal-form-{{ $modalId }}">--}}

    {{--                </div>--}}
    {{--                <div class="modal-footer d-block text-center d-lg-flex">--}}
    {{--                    <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>--}}
    {{--                    <button type="submit" class="mt-0 mt-lg-1 btn btn-primary">{{ __('Submit') }}</button>--}}
    {{--                    </form>--}}
    {{--                </div>--}}
    {{--            </div>--}}
    {{--        </div>--}}
    {{--    </div>--}}
    <!-- Modal end -->
    @push('scripts')
        {{--        <script type="text/javascript">--}}
        {{--            $('.{{ $triggerClass }}').click(function () {--}}
        {{--                let action = $(this).data('action');--}}
        {{--                $('#modal-form-{{ $modalId }}').attr('action', action);--}}
        {{--            })--}}
        {{--            $('#{{ $modalId }}').modal('hide');--}}
        {{--        </script>--}}

        <!-- DataTables  & Plugins -->
        <script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
        <script src="{{asset('admin/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        <script src="{{asset('admin/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{asset('admin/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
        <script src="{{asset('admin/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
        <script src="{{asset('admin/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
        <script src="{{asset('admin/plugins/jszip/jszip.min.js')}}"></script>
        <script src="{{asset('admin/plugins/pdfmake/pdfmake.min.js')}}"></script>
        <script src="{{asset('admin/plugins/pdfmake/vfs_fonts.js')}}"></script>
        <script src="{{asset('admin/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
        <script src="{{asset('admin/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
        <script src="{{asset('admin/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>
{!! $dataTable->scripts() !!}
@endpush
