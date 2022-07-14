@extends('layouts.admin.admin_layout',['title'=>'Create Customer'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Create Job"
                                      breadcrumbs='{"Home":"admin.dashboard","Job":"job.index","Create Job":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Job Details" form-route="job.store" form-id="create_job">
            <x-slot name="input">
                <x-admin.ui.input label="Customer" type="text" name="area" id="area" add-class=""
                                  placeholder="Enter New Area" required/>
                <x-admin.ui.input label="Zone" type="text" name="zone_id" id="zone_id" add-class=""
                                  placeholder="Enter Zone" required/>
                <x-admin.ui.input label="Zone" type="text" name="zone_id" id="zone_id" add-class=""
                                  placeholder="Enter Zone" required/>
            </x-slot>
            <x-slot name="button">
                <x-admin.ui.button type="submit" btn-name="Submit" name="customer_submit" id="customer_submit"/>
            </x-slot>
        </x-admin.ui.card-form>
        <!-- /.content -->
    @push('scripts')
        {{-- Custom JS --}}
    @endpush

@endsection
