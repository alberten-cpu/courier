@extends('layouts.admin.admin_layout',['title'=>'Create Customer'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Create Area"
                                      breadcrumbs='{"Home":"admin.dashboard","Area":"area.index","Create Area":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Area Details" form-route="area.store" form-id="create_area">
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="status" id="status" label="Status" onText="Active"
                                                 offText="Inactive"/>
                </div>
                <x-admin.ui.input label="Area Name" type="text" name="area" id="area" add-class=""
                                  placeholder="Enter New Area" required/>
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
