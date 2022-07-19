@if($accept)
    <a href="{{ $accept }}" class="btn btn-xs btn-primary"><i
            class="glyphicon glyphicon-edit" role="button"></i> {{__('Accept')}}</a>
@endif
@if($reject)
    <a class="btn btn-xs btn-danger delete" href="{{ $reject }}"
       onclick="event.preventDefault();document.getElementById('delete-form_{{ $id }}').submit();" role="button">
        <i class="glyphicon glyphicon-edit" role="button"></i>
        {{  __('Reject') }}
    </a>
    <form class="d-none delete-form" id="delete-form_{{ $id }}" action="{{ $reject }}" method="POST">
        @csrf
        @method('DELETE')
    </form>
@endif



