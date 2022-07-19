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
                                     name="customer_ref"
                                     id="customer_ref"
                />
                <div class="container-fluid bg-light">
                    <div class="card-body table-responsive pad">
                        <p class="mb-1">Adress Selection</p>
                        <div class="btn-group btn-group-toggle" data-toggle="buttons">
                            <label class="btn btn-secondary active">
                                <input type="radio" name="options" id="option_a1" autocomplete="off" checked> From Customer
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="options" id="option_a2" autocomplete="off"> To Customer
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="options" id="option_a3" autocomplete="off"> Neither
                            </label>
                        </div><br><br>
                    <div class="row">
                        <div class="col-lg-6">
                            <lable class="text-bold text-black-50">From Address</lable>
                            <x-admin.ui.input label="Address" type="text" name="from_address" id="from_address"
                                              add-class=""
                                              placeholder="From Address" required/>
                            <x-admin.ui.select label="Area"
                                               name="from_area_id"
                                               id="from_area_id"
                                               required
                                               options="area.list"
                                               add-class="from_area"
                                               required
                            />
                        </div>
                        <div class="col-lg-6">
                            <lable class="text-bold text-black-50">To Address</lable>
                            <x-admin.ui.input label="Address" type="text" name="to_address" id="to_address"
                                              add-class=""
                                              placeholder="To Address" required/>
                            <x-admin.ui.select label="Area"
                                               name="to_area_id"
                                               id="to_area_id"
                                               required
                                               options="area.list"
                                               add-class="to_area"
                                               required
                            />
                        </div>
                    </div>
                    <x-admin.ui.Textarea label="Notes"
                                         name="notes"
                                         id="note"
                    />
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <x-admin.ui.select label="Time Frame"
                                           name="timeframe_id"
                                           id="timeframe_id"
                                           required
                                           options="timeframe.list"
                                           add-class="timeframe_id"

                        />
                    </div>
                    <div class="col-lg-6">
                        <x-admin.ui.input label="Number of Boxes" type="number" name="number_box" id="number_box"
                                          add-class=""
                                          placeholder="Number of Boxes" required/>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="mt-4">
                            <label for="van_hire">Do you need van?
                                <x-admin.ui.bootstrap-switch name="van_hire" id="van_hire" onText="Yes"
                                                             offText="No"/>
                            </label>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <x-admin.ui.select label="Assign Driver"
                                           name="driver_id"
                                           id="driver_id"
                                           options="driver.list"
                                           add-class="driver_id"

                        />
                    </div>
                </div>
            </x-slot>
            <x-slot name="button">
                <x-admin.ui.button type="submit" btn-name="Submit" name="job_submit" id="job_submit"/>
            </x-slot>
        </x-admin.ui.card-form>
        <!-- /.content -->
    @push('scripts')
        {{-- Custom JS --}}
    @endpush

@endsection
