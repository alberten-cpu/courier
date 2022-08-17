<!-- Main content -->
<section class="content">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <!-- left column -->
            <div class="{{ $formClass }}">
                <!-- jquery validation -->
                <div class="card {{ $titleBgClass }}">
                    <div class="card-header">
                        <h3 class="card-title">{{ __($title) }} @if($smallTitle)
                                <small>{{ __($smallTitle) }}</small>
                            @endif</h3>
                    </div>
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="{{ $formId }}" name="{{ $formName }}"
                          action="{{ Helper::getRoute($formRoute,$formRouteId) }}"
                          method="{{ $formMethod }}" @if($enctype) enctype="multipart/form-data"
                          @endif @if($autocomplete) autocomplete="on" @else autocomplete="off" @endif {{ $other }}>
                        @csrf
                        @if($formRouteId)
                            @method('patch')
                        @endif
                        <div class="card-body">
                            {{ $input }}
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer">
                            {{ $button }}
                        </div>
                    </form>
                </div>
                <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
