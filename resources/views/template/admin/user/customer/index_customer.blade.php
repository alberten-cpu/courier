@extends('layouts.admin.admin_layout',['title'=>'Create Customer'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
        <!-- DataTables -->
        <link rel="stylesheet" href="{{asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
        <link rel="stylesheet"
              href="{{asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Create Customer"
                                      breadcrumbs='{"Home":"admin.dashboard","User":"","Customer":""}'/>
        <!-- /.content-header -->

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">DataTable with default features</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                {!! $dataTable->table() !!}
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.content -->
        @push('scripts')
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

@endsection
