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
<!-- ChartJS -->
<script src="{{asset('admin/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('admin/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('admin/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('admin/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('admin/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('admin/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('admin/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('admin/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('admin/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('admin/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('admin/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('admin/dist/js/pages/dashboard.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{asset('admin/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
<!-- Toastr -->
<script src="{{asset('admin/plugins/toastr/toastr.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('admin/dist/js/demo.js')}}"></script>

{{-- Custom JS --}}
<script src="{{ asset('js/custom.js') }}"></script>
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
</script>

{{ $slot }}

