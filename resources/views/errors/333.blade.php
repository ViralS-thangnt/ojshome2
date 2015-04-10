<html>
	<head>
		<link href='http://fonts.googleapis.com/css?family=Lato:100' rel='stylesheet' type='text/css'>

		<style>
			body {
				margin: 0;
				padding: 0;
				width: 100%;
				height: 100%;
				color: #B0BEC5;
				display: table;
				font-weight: 100;
				font-family: 'Lato';
			}

			.container {
				text-align: center;
				display: table-cell;
				vertical-align: middle;
			}

			.content {
				text-align: center;
				display: inline-block;
			}

			.title {
				font-size: 72px;
				margin-bottom: 40px;
			}
		</style>
	</head>
	<body>
		<div class="container">
			<div class="content">
				<div class="title">Error 404.</div>
				<div class="center red"><h2>{{ trans('admin.error.333.message') }}</h2></div>
				<div class="center"><a href="javascript:history.go(-1)"><< GO BACK</a></div>
				<div class="center"><span></span><a href="{{url('admin/')}}">Home >></a></div>
			</div>
		</div>
	</body>
</html>
