<!-- manuscript_in_review.php -->
@extends('layout.master.master')
<!-- Header Title -->
@section('title-page-admin')
<!-- Tác giả -->
<!-- Journal Open Source -->
<!-- Bản thảo -->
{!! Lang::get('admin.manuscript.title_page_admin') !!}

@stop


<!-- Page Title -->
@section('title')
	 {!! Lang::get('admin.manuscript.title') !!}
	
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
	 <h3 class="box-title">{!! Lang::get('admin.manuscript.header_title') !!}</h3>
</div><!-- /.box-header -->
<div class="box-body table-responsive">
	 <div id="table_data_wrapper" class="dataTables_wrapper form-inline" role="grid">
<!-- form start -->   
{!! Form::open(array('id' =>'form-manuscripts' , )) !!}
{{-- 
{!! Form::model($manuscripts, ['route' => ['manuscript.update', $id], 'enctype' => 'multipart/form-data', 'id' => 'form-manuscript'] ) !!} --}}
		<!-- Table -->
		<table id="table_data" class="table table-bordered table-striped dataTable" aria-describedby="table_data_info">
		<thead>
			<tr role="row">
				<td>{!! Form::checkbox('checkbox-name', 'all-check') !!}</td>
				@foreach($result['col_header'] as $head)
					 <th class="sorting_asc center" role="columnheader" tabindex="0" aria-controls="table_data" rowspan="1" colspan="1">{{$head}}</th>
				@endforeach
				<th rowspan="1" colspan="1" class="center">{!! Lang::get('admin.manuscript.detail') !!}</th>
			</tr>
		</thead>

		<tbody role="alert" aria-live="polite" aria-relevant="all">
			<input type="hidden" value ='{!! $is_odd = true !!}'/>
			@foreach($result['data'] as $row)
				
				<tr class="{{ ($is_odd) ? 'odd' : 'even' }}">
				<td><input type="checkbox" name="{{ $row->id }}" value="checked" checkall /></td>
					@foreach( $result['col_db'] as $col)						
							<td class="center" > {{ empty($row->$col) ? '-' : $row->$col }} </td>
					@endforeach
					
					<td class="center"><a href = "{{ url('admin/editor-manuscript/form/' . $row->id) }}"> {!! Lang::get('admin.manuscript.more_detail') !!} </a></td>
				</tr>

			@endforeach

		</tbody>

		<tfoot>
			<tr>
				<td>{!! Form::checkbox('name', 'all-check') !!}</td>				
				@foreach($result['col_header'] as $head)
					 <th class="sorting_asc center" role="columnheader" tabindex="0" aria-controls="table_data" rowspan="1" colspan="1">{{$head}}</th>
				@endforeach
				<th rowspan="1" colspan="1" class="center">{!! Lang::get('admin.manuscript.detail') !!}</th>

			</tr>
		</tfoot>

		</table>
		

	{{-- <input type="hidden" name="status" id="submit-form" /> --}}
	{!! Form::button(trans('admin.manuscript.create.save'), ['class' => 'btn btn-primary']) !!}
{!! Form::close() !!}
	</div><!-- datatable_wrapper -->

<script type="text/javascript">
	function checkAll(checkbox){
			if(checkbox){
				$("input[checkall]").prop('checked',true);
				$(".icheckbox_minimal").attr('aria-checked', 'true');
				$('.icheckbox_minimal').addClass('checked');
			}else{
				$("input[checkall]").prop('checked',false);
				$(".icheckbox_minimal").attr('aria-checked', 'false');
				$('.icheckbox_minimal').removeClass('checked');			
			}
	}
	$(document).ready(function(){
		$("thead .iCheck-helper").click(function(){			
		var checkbox = $("thead input[value='all-check']").is(':checked');
			checkAll(checkbox);
			$("tfoot input[value='all-check']").prop('checked',true);
		});
		$("tfoot .iCheck-helper").click(function(){
			var checkbox = $("tfoot input[value='all-check']").is(':checked');
			checkAll(checkbox);
			$("thead input[value='all-check']").prop('checked',true);
		});
	});
	//submit form
		$('.btn-primary').click(function(){	
			$('#form-manuscripts').submit();
		});
</script>
</div><!-- /.box-body -->
</div>

@stop
