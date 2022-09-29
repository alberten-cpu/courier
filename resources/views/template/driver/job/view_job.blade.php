@php use App\Models\JobAssign;use App\Models\JobStatus; @endphp
@extends('layouts.admin.admin_layout',['title'=>'My Job'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="My Job"
                                      breadcrumbs='{"Home":"dashboard","Job":"myjob.index","Accepted Job":"myjob.create","Update Job":""}'/>
        <!-- /.content-header -->
        <x-admin.ui.card-form title="" form-route="myjob.update" form-id="change_status"
                              form-route-id="{{ collect(request()->segments())->last() }}">
            <x-slot name="input">
                <div class="row">
                    <div class="col-lg-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h5 class="text-bold">From Address</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-sm-4">Company Name</dt>
                                    <dd class="col-sm-8">{{ $myjob->fromAddress->company_name }}</dd>
                                    <dt class="col-sm-4">Street Number</dt>
                                    <dd class="col-sm-8">{{ $myjob->fromAddress->street_number }}</dd>
                                    <dt class="col-sm-4">Suburb</dt>
                                    <dd class="col-sm-8">{{ $myjob->fromAddress->suburb }}</dd>
                                    <dt class="col-sm-4">City</dt>
                                    <dd class="col-sm-8">{{ $myjob->fromAddress->city }}</dd>
                                    <dt class="col-sm-4">State/Region</dt>
                                    <dd class="col-sm-8">{{ $myjob->fromAddress->state }}</dd>
                                    <dt class="col-sm-4">Postal Code</dt>
                                    <dd class="col-sm-8">{{ $myjob->fromAddress->zip }}</dd>
                                    <dt class="col-sm-4">Country</dt>
                                    <dd class="col-sm-8">{{ $myjob->fromAddress->country }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h5 class="text-bold">To Address</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                <dl class="row">
                                    <dt class="col-sm-4">Company Name</dt>
                                    <dd class="col-sm-8">{{ $myjob->toAddress->company_name }}</dd>
                                    <dt class="col-sm-4">Street Number</dt>
                                    <dd class="col-sm-8">{{ $myjob->toAddress->street_number }}</dd>
                                    <dt class="col-sm-4">Suburb</dt>
                                    <dd class="col-sm-8">{{ $myjob->toAddress->suburb }}</dd>
                                    <dt class="col-sm-4">City</dt>
                                    <dd class="col-sm-8">{{ $myjob->toAddress->city }}</dd>
                                    <dt class="col-sm-4">State/Region</dt>
                                    <dd class="col-sm-8">{{ $myjob->toAddress->state }}</dd>
                                    <dt class="col-sm-4">Postal Code</dt>
                                    <dd class="col-sm-8">{{ $myjob->toAddress->zip }}</dd>
                                    <dt class="col-sm-4">Country</dt>
                                    <dd class="col-sm-8">{{ $myjob->toAddress->country }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <div class="card-title">
                                    <h5 class="text-bold">Note</h5>
                                </div>
                            </div>
                            <div class="card-body">
                                {{ $myjob->notes ?? 'No Comments' }}
                            </div>
                        </div>
                    </div>
                    @if($myjob->jobAssign->status==JobAssign::JOB_ACCEPTED && ($myjob->status_id==JobStatus::ORDER_PLACED || $myjob->status_id==JobStatus::DELIVERY_ACCEPTED))
                        <div class="col-12">
                            <x-admin.ui.select label="Status"
                                               name="status"
                                               id="status"
                                               required
                                               :options="Helper::getJobStatus()"
                                               add-class="status"
                                               :value="$myjob->status_id"
                            />
                        </div>
                    @endif
                </div>
            </x-slot>
            @if($myjob->jobAssign->status==JobAssign::JOB_ACCEPTED && ($myjob->status_id==JobStatus::ORDER_PLACED || $myjob->status_id==JobStatus::DELIVERY_ACCEPTED))
                <x-slot name="button">
                    <x-admin.ui.button type="submit" btn-name="Submit" name="job_submit" id="job_submit"/>
                </x-slot>
            @endif
        </x-admin.ui.card-form>
    </div>
    @push('scripts')
        <script>


            function changeStatus(id, status) {

            }

        </script>
    @endpush
@endsection
