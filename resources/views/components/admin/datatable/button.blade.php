@if($edit)
    <a href="{{ $edit }}" class="btn btn-xs btn-primary"><i
            class="glyphicon glyphicon-edit" role="button"></i> {{__('Edit')}}</a>
@endif
@if($delete)
    <a class="btn btn-xs btn-danger delete" href="{{ $delete }}"
       onclick="event.preventDefault();document.getElementById('delete-form_{{ $id }}').submit();" role="button">
        <i class="glyphicon glyphicon-edit" role="button"></i>
        {{  __('Delete') }}
    </a>
    <form class="d-none delete-form" id="delete-form_{{ $id }}" action="{{ $delete }}" method="POST">
        @csrf
        @method('DELETE')
    </form>
@endif


