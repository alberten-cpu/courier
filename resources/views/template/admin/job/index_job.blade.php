@extends('layouts.admin.admin_layout',['title'=>'Job Listing'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush
    <x-admin.ui.datatable :data-table="$dataTable" title="Job Listing">
        <x-slot name="breadcrumb">
            <x-admin.title-and-breadcrumb title="Job"
                                          breadcrumbs='{"Home":"admin.dashboard","Job":""}'/>
        </x-slot>
    </x-admin.ui.datatable>

    <div class="modal fade" id="modal-sm-assign">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <form action="{{ Helper::getRoute('job.assignDriver') }}" method="post">
                    @csrf
                    <div class="modal-header">
                        <h4 class="modal-title">{{ __('Assign Driver') }}</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-lg-12">
                                <x-admin.ui.select label="Select Driver"
                                                   name="driver_id"
                                                   id="driver_id"
                                                   options="driver.list"
                                                   add-class="driver_id"
                                                   required

                                />
                                <input type="hidden" name="job_id" id="job_id" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">{{ __('Assign') }}</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
    @push('scripts')
        <script>
            $('body').on('click', '.assign-driver', function (e) {
                e.preventDefault();
                $('#job_id').val($(this).data('id'));
            });
            $('body').on('click', '.mass-assign-checkbox', function () {
                if ($('.mass-assign-checkbox:checked').length > 0) {
                    $('.mass-assign').removeClass('disabled');
                } else {
                    $('.mass-assign').addClass('disabled');
                }
            });
            $('body').on('click', '.mass-assign', function () {
                let job_id = [];
                $('.mass-assign-checkbox:checked').each(function (index) {
                    job_id[index] = $(this).val();
                });
                $('#job_id').val(JSON.stringify(job_id));
                $('#modal-sm-assign').modal('show');
            });

        </script>
    @endpush
@endsection
