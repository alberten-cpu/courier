@extends('layouts.admin.admin_layout',['title'=>'Job Listing'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush
    <x-admin.ui.datatable :data-table="$dataTable" title="Job Listing">
        <x-slot name="breadcrumb">
            <x-admin.title-and-breadcrumb title="Job"
                                          breadcrumbs='{"Home":"admin.dashboard","Job":""}'/>
        </x-slot>
    </x-admin.ui.datatable>
    @push('scripts')
        {{--Custom JS--}}
    @endpush
    `
@endsection
