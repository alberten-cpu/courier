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
                <x-admin.ui.select label="Customer"
                                   name="customer"
                                   id="customer"
                                   required
                                   options="customer.list"
                                   add-class="customer"
                />
                <x-admin.ui.Textarea label="Customer Ref"
                                     name="street_address_2"
                                     id="street_address_2"
                />
                <div class="container-fluid bg-light">
                    <div class="row">
                        <div class="col-lg-6">
                            <lable class="text-bold text-black-50">From Address</lable>
                            <x-admin.ui.select label="Address"
                                               name="from_address"
                                               id="from_address"
                                               required
                                               options="area.list"
                                               add-class="from_address"
                            />
                            <x-admin.ui.select label="Area"
                                               name="from_area_id"
                                               id="from_area_id"
                                               required
                                               options="area.list"
                                               add-class="from_area"
                            />
                        </div>
                        <div class="col-lg-6">
                            <lable class="text-bold text-black-50">To Address</lable>
                            <x-admin.ui.select label="Address"
                                               name="to_address"
                                               id="to_address"
                                               required
                                               options="area.list"
                                               add-class="to_address"
                            />
                            <x-admin.ui.select label="Area"
                                               name="to_area_id"
                                               id="to_area_id"
                                               required
                                               options="area.list"
                                               add-class="to_area"
                            />
                        </div>
                    </div>
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
