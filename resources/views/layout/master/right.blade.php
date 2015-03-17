<!-- right.blade.php -->
<aside class="right-side">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            @yield('title')
            <small> @yield('title-extra') </small>
        </h1>

        @if (Session::has(SUCCESS_MESSAGE))
        <div class="alert alert-success alert-dismissable">
            <i class="fa fa-check"></i>
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            {!! Session::get(SUCCESS_MESSAGE) !!}
        </div>
        @endif

        @yield('navigation-link')
    </section>

    <!-- Main content -->
    <section class="content">

         @yield('content')

    </section>
   
</aside>

