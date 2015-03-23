<!-- report-rejected.blade.php -->
@extends('layout.master.master')
@section('content')

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

	<form id="submit-date" action="{!! url('admin/report/rejected') !!}" method="POST" >
		{!! Form::token() !!}
		<div class="container">
		<div class="row">
	        <div class="col-md-12">
				<!-- AREA CHART -->
			    <div class="box box-primary">
			        <div class="box-header">
			            <h3 class="box-title">Thông tin</h3>
			        </div>
			        <div class="box-body chart-responsive">

			            <div class="chart" id="revenue-chart" style="height: 300px;"></div>

					    <div class="col-md-12 center" style="height: 100px">

					    	<h3 class="box-title">Tổng số các bản thảo bị từ chối</h3>
					    </div>

					    <!-- DatePicker -->
						<div class="span5 col-md-3" id="sandbox-container">
							<div class="input-daterange input-group" id="datepicker" >
							    <input type="text" class="input-sm form-control" name="start" id="start" value="{!! $start !!}">
							    <span class="input-group-addon">to</span>
							    <input type="text" class="input-sm form-control" name="end" id="end"  value="{!! $end !!}">
							</div>
						</div>
						<div class="col-md-3">
							<input type="submit" class="btn btn-primary" value="Tìm "/>
						</div>

					</div><!-- /.box-body -->
				</div><!-- /.box -->

			</div><!-- /.col (RIGHT) -->
	    </div><!-- /.row -->
		</div>
	</form><!-- End submit-date -->


<div id="line-example"></div>

    <div id="temp"></div>
	<script type="text/javascript">
		// DatePicker
		$('#sandbox-container .input-daterange').datepicker({
			format: "dd/mm/yyyy",
		    //daysOfWeekDisabled: "0,6",
		    clearBtn: true,
		    todayHighlight: true
		});	

		// Chart Demo Data
	    $(function() {
	        "use strict";

	        var count = '@include("reports.var-data")';

	        //DONUT CHART
			var donut = new Morris.Donut({
				element: 'revenue-chart',
				resize: true,
				colors: ["#f56954", '#00a65a'],
				data: [
					{label: "Số Bản thảo \n bị từ chối ", value: count},
				],
				hideHover: 'auto'
			});
	    });
	</script>
@stop