<!-- manuscript_in_review.php -->
@extends('layout.master.master')
<!-- Header Title -->
@section('title-page-admin')
<!-- Tác giả -->
<!-- Journal Open Source -->
<!-- Bản thảo -->
{!! Lang::get('admin.manuscript.title_page_admin') !!}

@stop

<!-- Header Image -->
@section('user-avatar-header')

{!! Form::image_custom('img/avatar3.png', 'Your Image', IMAGE_CIRCLE) !!}

@stop


<!-- Navigation Link -->
@section('navigation-link')
	
	 <!-- {!! Form::navigate_link(ICON_DOCUMENT_TEXT,
								   ['Bản thảo', 'Bản thảo đang bình duyệt'],
								   [ url('admin/'), url('admin/manuscript-in-review')]) !!} -->
@stop


<!-- Welcome user -->
@section('avatar-user')

	 {!! Form::image_custom('img/avatar3.png', 'User Image', IMAGE_CIRCLE) !!}

@stop

@section('user-welcome')

@stop


<!-- Page Title -->
@section('title')
	 Bản thảo đang bình duyệt
	

@stop

<!-- Page Title Extra -->
@section('title-extra')

<!-- More extra - Page Title  -->

@stop



@section('content')
	
<script type="text/javascript">
	$(function() {
		$('#table_data').dataTable({
			"bPaginate": true,
			"bLengthChange": true,
			"bFilter": true,
			"bSort": true,
			"bInfo": true,
			"bAutoWidth": true
		});
	});
</script>

<div class="box">
<div class="box-header">
	 <h3 class="box-title">Thông tin các bản thảo</h3>
</div><!-- /.box-header -->
<div class="box-body table-responsive">
	 <div id="table_data_wrapper" class="dataTables_wrapper form-inline" role="grid">

		<!-- Table -->
		<table id="table_data" class="table table-bordered table-striped dataTable" aria-describedby="table_data_info">
		<thead>
			<tr role="row">
				@foreach($result['col_header'] as $head)
					 <th class="sorting_asc center" role="columnheader" tabindex="0" aria-controls="table_data" rowspan="1" colspan="1">{{$head}}</th>
				@endforeach
				<th rowspan="1" colspan="1" class="center">Chi tiết</th>
			</tr>
		</thead>

		<tfoot>
			<tr>
				@foreach($result['col_header'] as $head)
					 <th class="sorting_asc center" role="columnheader" tabindex="0" aria-controls="table_data" rowspan="1" colspan="1">{{$head}}</th>
				@endforeach
				<th rowspan="1" colspan="1" class="center">Chi tiết</th>
			</tr>
		</tfoot>
		<tbody role="alert" aria-live="polite" aria-relevant="all">
			<input type="hidden" value ='{!! $is_odd = true !!}'/>
			@foreach($result['data'] as $row)
				
				<tr class="{{ ($is_odd) ? 'odd' : 'even' }}">

					@foreach( $result['col_db'] as $col)						
							<td class="center" > {{ empty($row->$col) ? '-' : $row->$col }} </td>
					@endforeach
					
					<td class="center"><a href = "{{ url('admin/manuscript/form/' . $row->id) }}"> Xem thêm </a></td>
				</tr>

			@endforeach

		</tbody>
		</table>

	</div><!-- datatable_wrapper -->

</div><!-- /.box-body -->
</div>

@stop
