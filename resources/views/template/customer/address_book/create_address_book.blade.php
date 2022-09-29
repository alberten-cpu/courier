@extends('layouts.admin.admin_layout',['title'=>'Create New Address'])
@section('content')

    @push('styles')
        {{-- Custom Style --}}
    @endpush

    <!-- Content Header (Page header) -->
    <div class="content-header">
        <x-admin.title-and-breadcrumb title="Create New Address"
                                      breadcrumbs='{"Home":"dashboard","Address Book":"address_book.index","Create Address Book":""}'/>
        <!-- /.content-header -->

        <x-admin.ui.card-form title="Address Details" form-route="address_book.store" form-id="create_address_book">
            <x-slot name="input">
                <div class="mb-3">
                    <x-admin.ui.bootstrap-switch name="status" id="status" label="Status" onText="Active"
                                                 offText="Inactive"/>
                </div>
                <x-admin.ui.input label="Company Name" type="text" name="company_name_address_book"
                                  id="company_name_address_book"
                                  add-class="company_name"
                                  placeholder="Company Name" required autocomplete/>
                <x-admin.address-autocomplete input-id="address_book"/>
                <div class="mb-3">
                    <label for="set_as_default">Set as default</label><br>
                    <x-admin.ui.bootstrap-switch name="set_as_default" id="set_as_default" label="Set" onText="Yes"
                                                 offText="No"/>
                </div>
            </x-slot>
            <x-slot name="button">
                <x-admin.ui.button type="submit" btn-name="Submit" name="address_book_submit" id="address_book_submit"/>
            </x-slot>
        </x-admin.ui.card-form>
        <!-- /.content -->
    @push('scripts')
        {{--            Custom JS--}}
    @endpush

@endsection
