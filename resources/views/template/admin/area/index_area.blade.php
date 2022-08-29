@extends('layouts.admin.admin_layout',['title'=>'Area'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush
    <x-admin.ui.datatable :data-table="$dataTable" title="Area Listing">
        <x-slot name="breadcrumb">
            <x-admin.title-and-breadcrumb title="Customer"
                                          breadcrumbs='{"Home":"dashboard","Area":""}'/>
        </x-slot>
    </x-admin.ui.datatable>
    @push('scripts')
        {{--Custom JS--}}
    @endpush
    `
@endsection
