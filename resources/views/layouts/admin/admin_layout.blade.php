<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-admin.head>
    @stack('styles')
</x-admin.head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <x-admin.preloader/>
    <x-admin.navbar/>
    <x-admin.sidebar/>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @yield('content')
    </div>
    <!-- /.content-wrapper -->
    <x-admin.footer/>
    <!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->
<x-admin.foot>
    @stack('scripts')
</x-admin.foot>
</body>
</html>
