<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>@yield('page-title')</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <!-- bootstrap 3.0.2 -->
        <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- font Awesome -->
        <link href="{{ url('assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
        <!-- Theme style -->
        <link href="{{ url('assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />

        <!-- jQuery 2.0.2 -->
        <script src="{{ url('assets/js/jquery.min.js') }}  "></script>
        <!-- Bootstrap -->
        <script src="{{ url('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
        <style type="text/css">
            .form-box{
                width: 700px;
            }
        </style>
    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">@yield('title')</div>
            <div class="body bg-gray">
                @yield('content')
            </div>
        </div>
    </body>
</html>