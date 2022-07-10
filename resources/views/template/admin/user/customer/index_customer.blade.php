@extends('layouts.admin.admin_layout',['title'=>'Create Customer'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
        <!-- DataTables -->
        <link rel="stylesheet" href="{{asset('admin/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
        <link rel="stylesheet"
              href="{{asset('admin/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
    @endpush
    <x-admin.ui.datatable :data-table="$dataTable" title="Customer Listing">
        <x-slot name="breadcrumb">
            <x-admin.title-and-breadcrumb title="Create Customer"
                                          breadcrumbs='{"Home":"admin.dashboard","User":"","Customer":""}'/>
        </x-slot>
    </x-admin.ui.datatable>
    @push('scripts')
        {{--        Custom JS--}}
    @endpush
    `
@endsection
