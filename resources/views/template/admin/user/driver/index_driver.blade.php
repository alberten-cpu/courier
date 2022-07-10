@extends('layouts.admin.admin_layout',['title'=>'Create Listing'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush
    <x-admin.ui.datatable :data-table="$dataTable" title="Driver Listing">
        <x-slot name="breadcrumb">
            <x-admin.title-and-breadcrumb title="Driver"
                                          breadcrumbs='{"Home":"admin.dashboard","User":"","Driver":""}'/>
        </x-slot>
    </x-admin.ui.datatable>
    @push('scripts')
        {{--Custom JS--}}
    @endpush
    `
@endsection
