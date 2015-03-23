<!DOCTYPE html>
<html>
	<head>
		
		<title>Admin Page</title>
		<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

		<!-- OJS New System -->
		<script src="{{ url('assets/js/ojs.js') }}" type="text/javascript"></script>

		<!-- bootstrap 3.0.2 -->
		<link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
		<!-- font Awesome -->
		<link href="{{ url('assets/css/font-awesome.min.css') }}" rel="stylesheet" type="text/css" />
		<!-- Ionicons -->
		<link href="{{ url('assets/css/ionicons.min.css') }}" rel="stylesheet" type="text/css" />
		<!-- Morris chart -->
		<link href="{{ url('assets/css/morris/morris.css') }}" rel="stylesheet" type="text/css" />
		<!-- jvectormap -->
		<link href="{{ url('assets/css/jvectormap/jquery-jvectormap-1.2.2.css') }}" rel="stylesheet" type="text/css" />
		<!-- Date Picker -->
		<link href="{{ url('assets/css/datepicker/datepicker3.css') }}" rel="stylesheet" type="text/css" />
		<!-- Daterange picker -->
		<link href="{{ url('assets/css/daterangepicker/daterangepicker-bs3.css') }}" rel="stylesheet" type="text/css" />
		<!-- bootstrap wysihtml5 - text editor -->
		<link href="{{ url('assets/css/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css') }}" rel="stylesheet" type="text/css" />
		<!-- Theme style -->
		<link href="{{ url('assets/css/AdminLTE.css') }}" rel="stylesheet" type="text/css" />
		<!-- Custom style -->
		<link href="{{ url('assets/css/style.css') }}" rel="stylesheet" type="text/css" />

		<!-- jQuery 2.0.2 -->
		<script src="{{ url('assets/js/jquery.min.js') }}  "></script>
		<!-- jQuery UI 1.10.3 -->
		<script src="{{ url('assets/js/jquery-ui-1.10.3.min.js') }}" type="text/javascript"></script>
		<!-- Bootstrap -->
		<script src="{{ url('assets/js/bootstrap.min.js') }}" type="text/javascript"></script>
		<!-- Morris.js charts -->
		<script src="{{ url('assets/js/raphael-min.js') }}"></script>
		<script src="{{ url('assets/js/plugins/morris/morris.min.js') }}" type="text/javascript"></script>

		<!-- Sparkline -->
		<script src="{{ url('assets/js/plugins/sparkline/jquery.sparkline.min.js') }}" type="text/javascript"></script>

		<!-- jvectormap -->
		<script src="{{ url('assets/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}" type="text/javascript"></script>
		<script src="{{ url('assets/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}" type="text/javascript"></script>
		<!-- jQuery Knob Chart -->
		<script src="{{ url('assets/js/plugins/jqueryKnob/jquery.knob.js') }}" type="text/javascript"></script>
		<!-- daterangepicker -->
		<script src="{{ url('assets/js/plugins/daterangepicker/daterangepicker.js') }}" type="text/javascript"></script>
		<!-- datepicker -->
		<script src="{{ url('assets/js/plugins/datepicker/bootstrap-datepicker.js') }}" type="text/javascript"></script>
		<!-- Bootstrap WYSIHTML5 -->
		<script src="{{ url('assets/js/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}" type="text/javascript"></script>
		<!-- iCheck -->
		<script src="{{ url('assets/js/plugins/iCheck/icheck.min.js') }}" type="text/javascript"></script>

		<!-- AdminLTE App -->
		<script src="{{ url('assets/js/AdminLTE/app.js') }}" type="text/javascript"></script>

		<!-- DATA TABES SCRIPT -->
		<script src="{{ url('assets/js/plugins/datatables/jquery.dataTables.js') }} " type="text/javascript"></script>

		<script src="{{ url('assets/js/plugins/datatables/dataTables.bootstrap.js') }}" type="text/javascript"></script>

		<!-- DATA TABLES -->
		<link href="{{ url('assets/css/datatables/dataTables.bootstrap.css') }}" rel="stylesheet" type="text/css" />

	</head>
	<title>
		@yield('title')
	</title>
	<body class="skin-blue {{ empty($result['body-class']) ? null :$result['body-class']}} ">
		@include('layout.master.header')

		<div class="wrapper row-offcanvas row-offcanvas-left" style="min-height: 648px;">
		
			@include('layout.master.left')
			@include('layout.master.right')
		
		</div>
		@include('layout.master.footer')

	</body>
</html>