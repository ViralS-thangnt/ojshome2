@extends('layout.master.master')

<!-- Left column -->
@section('left-column')
{!! getMenuItem($permissions) !!} 
@stop

@section('title-page-admin')
{!! Lang::get('admin.journal.title') !!}
@stop

@section('title')
{!! Lang::get('admin.journal.journal_info')  !!}
@stop

@section('navigation-link')

{!! Form::navigate_link(ICON_MENU_BOOK, [
						trans('admin.journal.create.navigation.journal') => url('admin/journal'), 
						trans('admin.journal.create.navigation.create') => url('admin/journal/form')]) !!}

@stop

<!-- Content -->
@section('content')

<!-- form start -->   
{!! Form::model($journal, ['route' => ['journal.update', $id], 'files' => true, 'id' => 'form-manuscript'] ) !!}

<!-- <div class="box box-primary"> -->
<div class="box box-primary padding-box">	
	
	<!-- box-header -->
	<div class="box-header">	
		{!! Form::h_custom(3, Lang::get('admin.journal.create.detail.header'), 'box-title') !!}
	</div><!-- /.box-header -->
	
	
	<div class="box-body">	
	
		{!! ErrorDisplay::getInstance()->DisplayAll($errors) !!}


		<div class="form-group">
			{!! Form::label_custom(Lang::get('admin.journal.create.name'), 'text-form-large', true)!!}

			{!! Form::help_block(Lang::get('admin.journal.create.help.name')) !!}

			{!! Form::textarea_custom('name', null, 3, Lang::get('admin.journal.create.placeholder.name'), 'form-control',
							['onkeyup' => 'countWords(this, 20, 2, "black", "red", "countTopicName")'] ) !!}

			<div id="countTopicName"></div>
			
		</div>

		<div class="form-group">
			{!! Form::label_custom(Lang::get('admin.journal.create.num'), 'text-form-large', true)!!}

			{!! Form::help_block(Lang::get('admin.journal.create.help.num')) !!}

			{!! Form::textarea_custom('num', null, 2, Lang::get('admin.journal.create.placeholder.num'), 'form-control',
							['onkeyup' => 'countWords(this, 200, 1, "black", "red", "countSummaryVn")'] ) !!}
			
			<div id="countSummaryVn"></div>

		</div>

		<div class="form-group">

			{!! Form::label_custom(Lang::get('admin.journal.create.expect_publish'), 'text-form-large')!!}

			{!! Form::help_block(Lang::get('admin.journal.create.help.publish')) !!}

			@if(isset($journal->publish_at) && !is_null($journal->publish_at))

				{!! Form::text('publish_at',date('Y/m/d', strtotime($journal->publish_at)),['class'=>'datepicker']) !!}
			@else
				{!!Form::text('publish_at','',['class' => 'datepicker']) !!}
			@endif
			 
		</div>

		<div class="form-group">

			{!! Form::label_custom(Lang::get('admin.journal.create.publish'), 'text-form-large', true)!!}

			{!! Form::help_block(Lang::get('admin.journal.create.help.expect_publish')) !!}
			
			@if(isset($journal->expect_publish_at) && !is_null($journal->expect_publish_at))

				{!! Form::text('expect_publish_at',date('Y/m/d', strtotime($journal->expect_publish_at)),['class'=>'datepicker']) !!}

			@else
				{!! Form::text('expect_publish_at','',['class'=>'datepicker']) !!}

			@endif
			 
		</div>

	</div><!-- end .box-body -->
	
</div><!-- /.box box-primary -->


<!-- Upload file -->
<div class="box box-primary">	
	<!-- box-header -->
	<div class="box-header padding-box">	
		{!! Form::label_custom(Lang::get('admin.journal.create.upload.header'), 'text-form-large')!!}
	</div><!-- /.box-header -->	

	
	<!-- box-body -->
	<div class="box-header">

		<div class="form-group">
	
		
		@if(isset($journal->cover) && ($journal->cover)!="")
			<input type="hidden" id="imgUrl" name="imgUrl" value="{!! url('/images/'.$journal->cover) !!}" alt="cover image"/>
		@else
			<input type="hidden" id="imgUrl" name="imgUrl" value="" alt="cover image" />
		@endif	 

		
		<img name="imgCover" id="imgCover"/>
		<p></p>

		<input type="file" id="cover" name="cover"/>
		</div>

	</div>

</div><!-- /.box box-primary -->

	
<!-- Submit	 -->

 {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
<!-- End form -->
{!! Form::close() !!}

<script>
    $('.datepicker').datepicker({
    	format: "yyyy/mm/dd",
    });
    
	$(document).ready(function(){

		document.getElementById("imgCover").src = document.getElementById("imgUrl").value;

		$("#cover").change(function(){
	    	readURL(this);
		});

	});      

	function readURL(input) {

	    if (input.files && input.files[0]) {
	        var reader = new FileReader();

	        reader.onload = function (e) {
	            $('#imgCover').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}

</script>



@stop

