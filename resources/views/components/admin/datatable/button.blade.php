@if(isset($edit))
    <a href="{{ $edit }}" class="btn btn-xs btn-primary"><i
            class="glyphicon glyphicon-edit" role="button"></i> {{__('Edit')}}</a>
@endif
@if(isset($delete))
    <a class="btn btn-xs btn-danger delete" href="{{ $delete }}" role="button" onclick="event.preventDefault();"
       data-toggle="modal"
       data-target="#modal-sm-{{ $id }}">
        <i class="glyphicon glyphicon-edit" role="button"></i>
        {{  __('Delete') }}
    </a>
    <div class="modal fade" id="modal-sm-{{ $id }}">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">{{  __('Delete') }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>{{__('Are you sure ?')}}</p>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{{__("Close")}}</button>
                    <form class="d-none delete-form" id="delete-form_{{ $id }}" action="{{ $delete }}"
                          method="POST">
                        @csrf
                        @method('DELETE')
                    </form>
                    <button type="submit" class="btn btn-primary"
                            onclick="event.preventDefault();document.getElementById('delete-form_{{ $id }}').submit();">{{  __('Delete') }}</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
@endif
@if(isset($assign))
    <a href="#" class="btn btn-xs btn-success assign-driver" onclick="event.preventDefault();"
       data-toggle="modal"
       data-target="#modal-sm-assign" data-id="{{ $id }}"><i
            class="glyphicon glyphicon-edit" role="button"></i> {{__('Assign')}}</a>
@endif
