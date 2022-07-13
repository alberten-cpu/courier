@extends('layouts.admin.admin_layout',['title'=>'Update Driver'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Update Driver"
                                      breadcrumbs='{"Home":"admin.dashboard","User":"","Driver":"driver.index","Update Driver":""}'/>
        <!-- /.content-header -->
        <x-admin.ui.card-form title="Driver Details" form-route="driver.update" form-route-id="{{ $driver->id }}"
                              form-id="update_driver">
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="is_active" id="is_active" label="Status" onText="Active"
                                                 offText="Inactive" value="{{ $driver->is_active }}"/>
                </div>
                <x-admin.ui.input label="Driver ID" type="text" name="did" id="did" add-class=""
                                  placeholder="Driver ID" value="{{ $driver->driver->driver_id }}" required/>
                <x-admin.ui.input label="First Name" type="text" name="first_name" id="first_name" add-class=""
                                  placeholder="First Name" required value="{{ $driver->first_name }}"/>
                <x-admin.ui.input label="Last Name" type="text" name="last_name" id="last_name" add-class=""
                                  placeholder="Last Name" required value="{{ $driver->last_name }}"/>
                <x-admin.ui.input label="Pager Number" type="text" name="pager_number" id="pager_number" add-class=""
                                  placeholder="Pager Number" value="{{ $driver->driver->pager_number }}" required/>
                <x-admin.ui.input label="Email"
                                  type="email"
                                  name="email"
                                  id="email"
                                  add-class=""
                                  placeholder="Email"
                                  required value="{{ $driver->email }}"/>
                <x-admin.ui.input label="Mobile"
                                  type="text"
                                  name="mobile"
                                  id="mobile"
                                  add-class=""
                                  placeholder="Mobile"
                                  required value="{{ $driver->mobile }}"/>
                <x-admin.ui.select label="Street Area"
                                   name="area_id"
                                   id="area_id"
                                   required
                                   value="{{ $driver->driver->area_id }}"
                                   :options="App\Models\Area::getAreas()"
                />
                <x-admin.ui.Textarea label="Street Adress 1"
                                     name="street_address_1"
                                     id="street_address_1"
                                     required
                                     value="{{ $driver->driver->street_address_1 }}"
                />
                <x-admin.ui.Textarea label="Street Adress 2"
                                     name="street_address_2"
                                     id="street_address_2"
                                     value="{{ $driver->driver->street_address_2 }}"
                />
            </x-slot>
            <x-slot name="button">
                <x-admin.ui.button type="submit" btn-name="Update" name="driver_update" id="driver_update"/>
            </x-slot>
        </x-admin.ui.card-form>
        <!-- /.content -->
    @push('scripts')
        {{-- Custom JS --}}
    @endpush

@endsection
