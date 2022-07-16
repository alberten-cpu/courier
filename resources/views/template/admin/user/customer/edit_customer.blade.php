@extends('layouts.admin.admin_layout',['title'=>'Update Customer'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Update Customer"
                                      breadcrumbs='{"Home":"admin.dashboard","User":"","Customer":"customer.index","Update Customer":""}'/>
        <!-- /.content-header -->
        <x-admin.ui.card-form title="Customer Details" form-route="customer.update" form-route-id="{{ $customer->id }}"
                              form-id="update_customer">
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="is_active" id="is_active" label="Status" onText="Active"
                                                 offText="Inactive" value="{{ $customer->is_active }}"/>
                </div>
                <x-admin.ui.input label="Customer Id" type="text" name="cid" id="cid" add-class=""
                                  placeholder="Enter Customer Id" required
                                  value="{{ $customer->customer->customer_id }}"/>
                <x-admin.ui.input label="First Name" type="text" name="first_name" id="first_name" add-class=""
                                  placeholder="First Name" required value="{{ $customer->first_name }}"/>
                <x-admin.ui.input label="Last Name" type="text" name="last_name" id="last_name" add-class=""
                                  placeholder="Last Name" required value="{{ $customer->last_name }}"/>
                <x-admin.ui.input label="Email"
                                  type="email"
                                  name="email"
                                  id="email"
                                  add-class=""
                                  placeholder="Email"
                                  required
                                  value="{{ $customer->email }}"/>
                <x-admin.ui.input label="Mobile"
                                  type="text"
                                  name="mobile"
                                  id="mobile"
                                  add-class=""
                                  placeholder="Mobile"
                                  required
                                  value="{{ $customer->mobile }}"/>
                <x-admin.ui.input label="Phone"
                                  type="text"
                                  name="phone"
                                  id="phone"
                                  add-class=""
                                  placeholder="Phone Number"
                                  value="{{ $customer->mobile }}"
                />
                <x-admin.ui.select label="Street Area"
                                   name="area_id"
                                   id="area_id"
                                   required
                                   value="{{ $customer->customer->area_id }}"
                                   options="area.list"
                                   add-class="area"
                />
                <x-admin.ui.Textarea label="Street Adress 1"
                                     name="street_address_1"
                                     id="street_address_1"
                                     required
                                     value="{{ $customer->customer->street_address_1 }}"

                />
                <x-admin.ui.Textarea label="Street Adress 2"
                                     name="street_address_2"
                                     id="street_address_2"
                                     value="{{ $customer->customer->street_address_2 }}"


                />
            </x-slot>
            <x-slot name="button">
                <x-admin.ui.button type="submit" btn-name="Update" name="customer_update" id="customer_update"/>
            </x-slot>
        </x-admin.ui.card-form>
        <!-- /.content -->
    @push('scripts')
        {{-- Custom JS --}}
    @endpush

@endsection
