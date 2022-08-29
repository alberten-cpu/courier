@extends('layouts.admin.admin_layout',['title'=>'Update Driver'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Update Driver"
                                      breadcrumbs='{"Home":"dashboard","Driver":"driver.index","Update Driver":""}'/>
        <!-- /.content-header -->
        <x-admin.ui.card-form title="Driver Details" form-route="driver.update" form-route-id="{{ $driver->id }}"
                              form-id="update_driver">
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="is_active" id="is_active" label="Status" onText="Active"
                                                 offText="Inactive" value="{{ $driver->is_active }}"/>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <x-admin.ui.input label="Driver ID" type="text" name="did" id="did" add-class=""
                                          placeholder="Driver ID" value="{{ $driver->driver->driver_id }}" required/>
                        <x-admin.ui.input label="First Name" type="text" name="first_name" id="first_name" add-class=""
                                          placeholder="First Name" required value="{{ $driver->first_name }}"/>
                        <x-admin.ui.input label="Last Name" type="text" name="last_name" id="last_name" add-class=""
                                          placeholder="Last Name" required value="{{ $driver->last_name }}"/>
                        {{--                <x-admin.ui.input label="Pager Number" type="text" name="pager_number" id="pager_number" add-class=""--}}
                        {{--                                  placeholder="Pager Number" value="{{ $driver->driver->pager_number }}" required/>--}}
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
                                           options="area.list"
                                           add-class="area"
                        />
                        <x-admin.ui.input label="Company Email"
                                          type="email"
                                          name="company_email"
                                          id="company_email"
                                          add-class=""
                                          placeholder="Company Email"
                                          value="{{ $driver->driver->company_email }}"
                        />
                        <label for="is_company_driver">Company Driver
                            <x-admin.ui.bootstrap-switch name="is_company_driver" id="is_company_driver"
                                                         label="" onText="Yes"
                                                         offText="No"
                                                         value="{{ $driver->driver->company_driver }}"/>
                        </label>
                    </div>
                    <div class="col-lg-6">
                        <x-admin.address-autocomplete input-id="driver" :edit-data="$driver"
                                                      relations="defaultAddress"/>
                    </div>
                </div>
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
