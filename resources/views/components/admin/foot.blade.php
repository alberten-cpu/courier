<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('admin/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('admin/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('admin/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin/dist/js/adminlte.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{asset('admin/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('admin/plugins/toastr/toastr.min.js')}}"></script>

{{-- Custom JS --}}
<script src="{{ asset('admin/js/custom.js') }}"></script>
<script>
    $(function () {
        let Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
        });

        @if ($errors->any())
        $(document).ready(function () {
            @foreach ($errors->all() as $error)
            toastr.error('{{ __($error) }}')
            @endforeach
        });
        @endif

        @if(session()->has('success'))
        $(document).ready(function () {
            Toast.fire({
                icon: 'success',
                title: '{{ __(session()->get('success')) }}'
            });
        });
        @endif

        @if(session()->has('error'))
        $(document).ready(function () {
            Toast.fire({
                icon: 'error',
                title: '{{ __(session()->get('error')) }}'
            });
        });
        @endif

        @if(session()->has('warning'))
        $(document).ready(function () {
            Toast.fire({
                icon: 'warning',
                title: '{{ __(session()->get('warning')) }}'
            });
        });
        @endif

        @if(session()->has('info'))
        $(document).ready(function () {
            Toast.fire({
                icon: 'info',
                title: '{{ __(session()->get('info')) }}'
            });
        });
        @endif

        @if(session()->has('question'))
        $(document).ready(function () {
            Toast.fire({
                icon: 'question',
                title: '{{ __(session()->get('question')) }}'
            });
        });
        @endif
    });

    function redirectBack() {
        location.href = '{{ url()->previous() }}';
    }
</script>

{{ $slot }}

