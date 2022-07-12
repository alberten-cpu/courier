@extends('layouts.admin.admin_layout',['title'=>'Create Customer'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Create Customer"
                                      breadcrumbs='{"Home":"admin.dashboard","User":"","Customer":"customer.index","Create Customer":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Customer Details" form-route="customer.store" form-id="create_customer">
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="is_active" id="is_active" label="Status" onText="Active"
                                                 offText="Inactive"/>
                </div>
                <x-admin.ui.input label="Customer Id" type="text" name="cid" id="cid" add-class=""
                                  placeholder="Enter Customer Id" required/>
                <x-admin.ui.input label="First Name" type="text" name="first_name" id="first_name" add-class=""
                                  placeholder="First Name" required/>
                <x-admin.ui.input label="Last Name" type="text" name="last_name" id="last_name" add-class=""
                                  placeholder="Last Name" required/>
                <x-admin.ui.input label="Email"
                                  type="email"
                                  name="email"
                                  id="email"
                                  add-class=""
                                  placeholder="Email"
                                  required/>
                <x-admin.ui.input label="Mobile"
                                  type="text"
                                  name="mobile"
                                  id="mobile"
                                  add-class=""
                                  placeholder="Mobile"
                                  required/>
                <x-admin.ui.input label="Phone"
                                  type="text"
                                  name="phone"
                                  id="phone"
                                  add-class=""
                                  placeholder="Phone Number"
                                  />
                <x-admin.ui.select label="Street Area"
                                    name="area_id"
                                    id="area_id"
                                    required
                                    :options="App\Models\Area::getAreas()"
                />
                <x-admin.ui.Textarea label="Street Adress 1"
                                   name="street_address_1"
                                   id="street_address_1"
                                   required

                />
                <x-admin.ui.Textarea label="Street Adress 2"
                                     name="street_address_2"
                                     id="street_address_2"


                />
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
