@extends('layouts.admin.admin_layout',['title'=>'Customer Listing'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush
    <x-admin.ui.datatable :data-table="$dataTable" title="">
        <x-slot name="breadcrumb">
            <x-admin.title-and-breadcrumb title="Customers"
                                          breadcrumbs='{"Home":"admin.dashboard","Customers":""}'/>
        </x-slot>
    </x-admin.ui.datatable>
    @push('scripts')
        {{--Custom JS--}}
    @endpush
    `
@endsection
