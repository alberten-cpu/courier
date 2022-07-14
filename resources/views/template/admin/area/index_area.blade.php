@extends('layouts.admin.admin_layout',['title'=>'Create Listing'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush
    <x-admin.ui.datatable :data-table="$dataTable" title="Customer Listing">
        <x-slot name="breadcrumb">
            <x-admin.title-and-breadcrumb title="Customer"
                                          breadcrumbs='{"Home":"admin.dashboard","User":"","Area":""}'/>
        </x-slot>
    </x-admin.ui.datatable>
    @push('scripts')
        {{--Custom JS--}}
    @endpush
    `
@endsection
