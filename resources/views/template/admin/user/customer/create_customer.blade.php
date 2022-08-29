@extends('layouts.admin.admin_layout',['title'=>'Create Customer'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Create Customer"
                                      breadcrumbs='{"Home":"dashboard","Customer":"customer.index","Create Customer":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Customer Details" form-route="customer.store" form-id="create_customer">
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="is_active" id="is_active" label="Status" onText="Active"
                                                 offText="Inactive"/>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <x-admin.ui.input label="Customer ID" type="text" name="cid" id="cid" add-class=""
                                          placeholder="Enter Customer ID" required/>
                        <x-admin.ui.input label="Company Name" type="text" name="company_name" id="company_name"
                                          add-class=""
                                          placeholder="Company Name" required/>
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
                        <x-admin.ui.select label="Street Area"
                                           name="area_id"
                                           id="area_id"
                                           required
                                           options="area.list"
                                           add-class="area"
                        />
                    </div>
                    <div class="col-lg-6">
                        <x-admin.address-autocomplete input-id="customer"/>
                    </div>
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
