@extends('layouts.admin.admin_layout',['title'=>'Address Book'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush
    <x-admin.ui.datatable :data-table="$dataTable" title="Address Book">
        <x-slot name="breadcrumb">
            <x-admin.title-and-breadcrumb title="Address"
                                          breadcrumbs='{"Home":"dashboard","Address Book":""}'/>
        </x-slot>
    </x-admin.ui.datatable>
    @push('scripts')
        {{--Custom JS--}}
    @endpush
    `
@endsection
