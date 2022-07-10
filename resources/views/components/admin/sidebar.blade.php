<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <x-admin.logo/>

    <!-- Sidebar -->
    <div class="sidebar">
        <x-admin.user-panel/>
        {{--        <x-admin.search-form/>--}}
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
                     with font-awesome or any other icon font library -->

                <x-admin.ui.menu name="Dashboard" route="admin.dashboard" icon="fas fa-tachometer-alt" target="0"
                                 new="0" count="0"/>
                {{--Admin Menus--}}
                @if(auth()->user()->isAdmin())
                    <x-admin.ui.dropdown-menu name="Users" icon="fas fa-th"
                                              menus='[{"label":"Customers","route":"customer.index","target":"0","new":"0","count":"0"},{"label":"Driver","route":"driver.index","target":"0","new":"0","count":"0"}]'/>
                @elseif(auth()->user()->isCustomer())
                    {{--Customer Menus--}}
                @elseif(auth()->user()->isDriver())
                    {{--Driver Menus--}}
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
