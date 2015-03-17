<!-- left-bar -->
<aside class="left-side sidebar-offcanvas" style="min-height: 3190px;">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar" id="left-menu">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                @yield('avatar-user') 
                <!-- <img src="img/avatar3.png" class="img-circle" alt="User Image"> -->
            </div>
            <div class="pull-left info">
                @yield('user-welcome')
            </div>
        </div>
        
        <!-- sidebar menu: : style can be found in sidebar.less -->
        @yield('left-column')                   
    </section>
</aside>
            