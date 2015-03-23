<!-- test-report.blade.php -->
@extends('layout.master.master')
@section('content')

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        	<!-- jQuery 2.0.2 -->

<body>
	<form id="submit-date" action="{!! url('admin/report/rejected') !!}" method="POST" >
		{!! Form::token() !!}
		<div class="container">
		<div class="row">
	        <div class="col-md-6">
				<!-- AREA CHART -->
			    <div class="box box-primary">
			        <div class="box-header">
			            <h3 class="box-title">Area Chart</h3>
			        </div>
			        <div class="box-body chart-responsive">

			            <div class="chart" id="revenue-chart" style="height: 300px;"></div>
			        </div><!-- /.box-body -->
			    </div><!-- /.box -->

			    <!-- DatePicker -->
				<div class="span5 col-md-5" id="sandbox-container">
					<div class="input-daterange input-group" id="datepicker" >
					    <input type="text" class="input-sm form-control" name="start" id="start" value="{!! $start !!}">
					    <span class="input-group-addon">to</span>
					    <input type="text" class="input-sm form-control" name="end" id="end"  value="{!! $end !!}">
					</div>
				</div>


			</div><!-- /.col (RIGHT) -->
	    </div><!-- /.row -->
	    <div class="row">
	    	<input type="submit" class="btn btn-primary" />
	    </div>
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
	        
	        // AREA CHART
	        var area = new Morris.Bar({
	            element: 'revenue-chart',
	            resize: true,
	            data: [
	                {y: '2011 Q1', item1: 2666, item2: 2666, item3: 2666},
	                {y: '2011 Q2', item1: 2778, item2: 2294, item3: 2666},
	                {y: '2011 Q3', item1: 4912, item2: 1969, item3: 2666},
	                {y: '2011 Q4', item1: 3767, item2: 3597, item3: 2666},
	                {y: '2012 Q1', item1: 6810, item2: 1914, item3: 2666},
	                {y: '2012 Q2', item1: 5670, item2: 4293, item3: 2666},
	            ],
	            xkey: 'y',
	            ykeys: ['item1', 'item2', 'item3'],
	            labels: ['Item 1', 'Item 2', 'Item 3'],
	            lineColors: ['#a0d0e0', '#3c8dbc', 'red'],
	            hideHover: 'auto'
	        });
	       
	        // //BAR CHART
	        // var bar = new Morris.Bar({
	        //     element: 'bar-chart',
	        //     resize: true,
	        //     data: [
	        //         {y: '2006', a: 100, b: 90},
	        //         {y: '2007', a: 75, b: 65},
	        //         {y: '2008', a: 50, b: 40},
	        //         {y: '2009', a: 75, b: 65},
	        //         {y: '2010', a: 50, b: 40},
	        //         {y: '2011', a: 75, b: 65},
	        //         {y: '2012', a: 100, b: 90}
	        //     ],
	        //     barColors: ['#00a65a', '#f56954'],
	        //     xkey: 'y',
	        //     ykeys: ['a', 'b'],
	        //     labels: ['CPU', 'DISK'],
	        //     hideHover: 'auto'
	        // });
	    });
	</script>
@stop