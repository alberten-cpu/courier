<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<x-admin.head>
    @stack('styles')
</x-admin.head>
<body>
    @yield('content')
<x-admin.foot>
    @stack('scripts')
</x-admin.foot>
</body>
</html>
