@extends('layouts.admin.admin_layout',['title'=>'Create Customer'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Edit Area"
                                      breadcrumbs='{"Home":"admin.dashboard","Area":"area.index","Edit Area":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Area Details" form-route="area.update" form-id="edit_area" form-route-id="{{ $area->id }}">
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="status" id="status" label="Status" onText="Active"
                                                 offText="Inactive"
                                                 value="{{ $area->status }}"/>
                </div>
                <x-admin.ui.input label="Area Name" type="text" name="area" id="area" add-class=""
                                  placeholder="Enter New Area" value="{{ $area->area }}" required/>
                <x-admin.ui.input label="Zone" type="text" name="zone_id" id="zone_id" add-class=""
                                  placeholder="Enter Zone" value="{{ $area->zone_id }}" required/>


            </x-slot>
            <x-slot name="button">
                <x-admin.ui.button type="submit" btn-name="Update" name="area_submit" id="area_submit"/>
            </x-slot>
        </x-admin.ui.card-form>
        <!-- /.content -->
    @push('scripts')
        {{-- Custom JS --}}
    @endpush

@endsection
