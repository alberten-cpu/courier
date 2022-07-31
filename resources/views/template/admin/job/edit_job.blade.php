@extends('layouts.admin.admin_layout',['title'=>'Update Job'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Update Job"
                                      breadcrumbs='{"Home":"admin.dashboard","Job":"job.index","Update Job":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Job Details" form-route="job.update" form-id="update_job"
                              form-route-id="{{ $job->id }}">
            <x-slot name="input">
                <x-admin.ui.select label="Customer"
                                   name="customer"
                                   id="customer"
                                   required
                                   options="customer.list"
                                   add-class="customer"
                                   :value="$job->user_id"
                />
                <x-admin.ui.input label="Customer Contact" type="text" name="customer_ref" id="customer_ref"
                                  add-class=""
                                  placeholder="Customer Contact" required :value="$job->customer_reference"/>
                <div class="container-fluid bg-light">
                    <div class="card-body table-responsive pad">
                        <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
                            <label class="btn btn-secondary active">
                                <input type="radio" name="default_address" id="from" value="from" autocomplete="off"
                                       class="default_address">From
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="default_address" id="to" value="to" autocomplete="off"
                                       class="default_address">To
                            </label>
                            <label class="btn btn-secondary">
                                <input type="radio" name="default_address" id="neither" value="neither"
                                       autocomplete="off" class="default_address" checked>Neither
                            </label>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <lable class="text-bold text-black-50">From Address</lable>
                                <a class="btn btn-link text-sm address-book float-right" data-toggle="modal"
                                   data-target="#modal-xl" data-id="from">Select From Address Book
                                </a>
                                <x-admin.address-autocomplete input-id="from" :edit-data="$job"
                                                              relations="fromAddress"/>
                                <input type="hidden" name="from_address_id" id="from_address_id"
                                       value="{{ old('from_address_id',$job->fromAddress->id) }}">
                                <x-admin.ui.select label="Area"
                                                   name="from_area_id"
                                                   id="from_area_id"
                                                   required
                                                   options="area.list"
                                                   add-class="from_area"
                                                   required
                                                   :value="$job->from_area_id"
                                />
                            </div>
                            <div class="col-lg-6">
                                <lable class="text-bold text-black-50">To Address</lable>
                                <a class="btn btn-link text-sm address-book float-right" data-toggle="modal"
                                   data-target="#modal-xl" data-id="to">Select From Address Book
                                </a>
                                <x-admin.address-autocomplete input-id="to" :edit-data="$job"
                                                              relations="toAddress"/>
                                <input type="hidden" name="to_address_id" id="to_address_id"
                                       value="{{ old('to_address_id',$job->toAddress->id) }}">
                                <x-admin.ui.select label="Area"
                                                   name="to_area_id"
                                                   id="to_area_id"
                                                   required
                                                   options="area.list"
                                                   add-class="to_area"
                                                   required
                                                   :value="$job->to_area_id"
                                />
                            </div>
                        </div>
                        <x-admin.ui.Textarea label="Notes"
                                             name="notes"
                                             id="note"
                                             :value="$job->notes"
                        />
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6">
                        <x-admin.ui.input label="Number of Boxes" type="number" name="number_box" id="number_box"
                                          add-class=""
                                          placeholder="Number of Boxes" required :value="$job->number_box"/>
                    </div>
                    <div class="col-lg-6">
                        <div class="mt-4">
                            <label for="van_hire">Do you need van?
                                <x-admin.ui.bootstrap-switch name="van_hire" id="van_hire" onText="Yes"
                                                             offText="No" label="Need" :value="$job->van_hire"/>
                            </label>
                        </div>
                    </div>
                </div>
                {{--                <div class="row">--}}
                {{--                    <div class="col-lg-6">--}}
                {{--                        <x-admin.ui.select label="Assign Driver"--}}
                {{--                                           name="driver_id"--}}
                {{--                                           id="driver_id"--}}
                {{--                                           options="driver.list"--}}
                {{--                                           add-class="driver_id"--}}

                {{--                        />--}}
                {{--                    </div>--}}
                {{--                    <div class="col-lg-6">--}}
                {{--                        <x-admin.ui.select label="Time Frame"--}}
                {{--                                           name="timeframe_id"--}}
                {{--                                           id="timeframe_id"--}}
                {{--                                           required--}}
                {{--                                           options="timeframe.list"--}}
                {{--                                           add-class="timeframe_id"--}}

                {{--                        />--}}
                {{--                    </div>--}}
                {{--                </div>--}}
            </x-slot>
            <x-slot name="button">
                <x-admin.ui.button type="submit" btn-name="Submit" name="job_submit" id="job_submit"/>
            </x-slot>
        </x-admin.ui.card-form>

        <div class="modal fade" id="modal-xl">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Address Book</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body my-address-book row">

                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>

        <!-- /.content -->
        @push('scripts')
            <script>
                $('#customer').change(function () {
                    let customerId = $(this).val();
                    let checkedAddress = $('input[name="default_address"]:checked').val();
                    getAddressData(customerId, checkedAddress, null);
                });

                function getAddressData(customerId, checkedAddress, id) {
                    $.ajax({
                        url: '{{ Helper::getRoute('job.getAddress') }}',
                        type: 'post',
                        data: {user_id: customerId, id: id},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            setAddressData(checkedAddress, result);
                            setAreaAddress(checkedAddress, result[0].id)
                        }
                    })
                }

                function setAddressData(type, data) {
                    $('#street_address_' + type).val(data.street_address).change();
                    $('#suburb_' + type).val(data.suburb).change();
                    $('#city_' + type).val(data.city).change();
                    $('#state_' + type).val(data.state).change();
                    $('#country_' + type).val(data.country).change();
                    $('#zip_' + type).val(data.zip).change();
                    $('#latitude_' + type).val(data.latitude).change();
                    $('#longitude_' + type).val(data.longitude).change();
                    $('#location_url_' + type).val(data.location_url).change();
                    $('#json_response_' + type).val(data.full_json_response).change();
                    $('#' + type + '_address_id').val(data.id).change();
                }

                function unSetAddressData(type) {
                    $('#street_address_' + type).val('').change();
                    $('#suburb_' + type).val('').change();
                    $('#city_' + type).val('').change();
                    $('#state_' + type).val('').change();
                    $('#country_' + type).val('').change();
                    $('#zip_' + type).val('').change();
                    $('#latitude_' + type).val('').change();
                    $('#longitude_' + type).val('').change();
                    $('#location_url_' + type).val('').change();
                    $('#json_response_' + type).val('').change();
                    $('#' + type + '_address_id').val('').change();
                    $('#' + type + '_area_id').val('').change();
                }

                function setAreaAddress(type, area_id) {
                    $('#' + type + '_area_id').select2({
                        placeholder: '--select--',
                        ajax: {
                            url: "{{ Helper::getRoute('area.list') }}",
                            type: "get",
                            dataType: 'json',
                            delay: 250,
                            data: function (params) {
                                return {
                                    search: params.term // search term
                                };
                            },
                            processResults: function (response) {
                                return {
                                    results: response
                                };
                            },
                            cache: true
                        },
                        initSelection: function (element, callback) {
                            let id = area_id;
                            if (id) {
                                $.ajax("{{ Helper::getRoute('area.list') }}", {
                                    data: {id: id},
                                    dataType: "json"
                                }).done(function (data) {
                                    let newOption = new Option(data[0].text, data[0].id, true, true);
                                    $('#' + type + '_area_id').append(newOption).trigger('change');
                                    callback(data);
                                });
                            }
                        }
                    });
                }

                $('.default_address').change(function () {
                    let customerId = $('#customer').val();
                    let checkedAddress = $(this).val();
                    if (checkedAddress == 'from') {
                        unSetAddressData('to');
                        getAddressData(customerId, checkedAddress);
                    } else if (checkedAddress == 'to') {
                        unSetAddressData('from');
                        getAddressData(customerId, checkedAddress);
                    } else {
                        unSetAddressData('from');
                        unSetAddressData('to');
                    }
                });

                $('.address-book').click(function () {
                    let customerId = $('#customer').val();
                    let type = $(this).data('id');
                    $('.my-address-book').empty();
                    if (customerId) {
                        getAddressBook(customerId, type);
                    } else {
                        $('.my-address-book').append(`
                                    <div class="col-md-12">
                            <div class="card border border-danger">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-map-marked"></i>
                                            Please select any customer first
                                    </h3>
                                </div>`);
                    }
                });

                function getAddressBook(customerId, type) {
                    $.ajax({
                        url: '{{ Helper::getRoute('job.getAddressBook') }}',
                        type: 'post',
                        data: {user_id: customerId},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function (result) {
                            if (result.length) {
                                $.each(result, function (index, address) {
                                    $('.my-address-book').append(`
                                    <div class="col-md-6">
                            <div class="card address-book-card" data-type="${type}" data-id="${address.id}">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <a href="${address.location_url}" target="_blank">
                                        <i class="fas fa-map-marked"></i>
                                        ${address.street_address}
                                        </a>
                                    </h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <dl class="row">
                                        <dt class="col-sm-4">Suburb</dt>
                                        <dd class="col-sm-8">${address.suburb}</dd>
                                        <dt class="col-sm-4">City</dt>
                                        <dd class="col-sm-8">${address.city}</dd>
                                        <dt class="col-sm-4">State/Region</dt>
                                        <dd class="col-sm-8">${address.state}</dd>
                                        <dt class="col-sm-4">Postal Code</dt>
                                        <dd class="col-sm-8">${address.zip}</dd>
                                        <dt class="col-sm-4">Country</dt>
                                        <dd class="col-sm-8">${address.country}</dd>
                                    </dl>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                                `);
                                });
                            } else {
                                $('.my-address-book').append(`
                                    <div class="col-md-12">
                            <div class="card border border-danger">
                                <div class="card-header">
                                    <h3 class="card-title">
                                        <i class="fas fa-map-marked"></i>
                                            No address found
                                    </h3>
                                </div>`);
                            }
                        }
                    })
                }

                $('body').on('click', '.address-book-card', function () {
                    $('.address-book-card').removeClass('border border-info');
                    $(this).toggleClass('border border-info');
                    let id = $(this).data('id');
                    let type = $(this).data('type');
                    getAddressData(null, type, id);
                    $('#modal-xl').modal('hide');
                })

            </script>
    @endpush

@endsection
