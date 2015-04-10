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
{!! Form::model($journal, ['route' => ['journal.update', $id], 'enctype' => 'multipart/form-data', 'id' => 'form-manuscript'] ) !!}

<!-- <div class="box box-primary"> -->
{!! Form::div_open('box box-primary padding-box') !!}
	
	<!-- box-header -->
	{!! Form::div_open('box-header') !!}
		{!! Form::h_custom(3, Lang::get('admin.journal.create.detail.header'), 'box-title') !!}
	{!! Form::div_close() !!}<!-- /.box-header -->
	
	
	{!! Form::div_open('box-body') !!}
	
		{!! ErrorDisplay::getInstance()->DisplayAll($errors) !!}


		{!! Form::div_open('form-group') !!}
			{!! Form::label_custom(Lang::get('admin.journal.create.name'), 'text-form-large', true)!!}

			{!! Form::help_block(Lang::get('admin.journal.create.help.name')) !!}

			{!! Form::textarea_custom('name', null, 3, Lang::get('admin.journal.create.placeholder.name'), 'form-control',
							['onkeyup' => 'countWords(this, 20, 2, "black", "red", "countTopicName")'] ) !!}

			{!! Form::div_open('', 'countTopicName') !!}{!! Form::div_close() !!}
			
		{!! Form::div_close() !!}

		{!! Form::div_open('form-group') !!}
			{!! Form::label_custom(Lang::get('admin.journal.create.num'), 'text-form-large', true)!!}

			{!! Form::help_block(Lang::get('admin.journal.create.help.num')) !!}

			{!! Form::textarea_custom('num', null, 2, Lang::get('admin.journal.create.placeholder.num'), 'form-control',
							['onkeyup' => 'countWords(this, 200, 1, "black", "red", "countSummaryVn")'] ) !!}
			
			{!! Form::div_open('', 'countSummaryVn') !!}{!! Form::div_close() !!}

		{!! Form::div_close() !!}

		{!! Form::div_open('form-group') !!}

			{!! Form::label_custom(Lang::get('admin.journal.create.publish'), 'text-form-large', true)!!}

			{!! Form::help_block(Lang::get('admin.journal.create.help.publish')) !!}

			@if(isset($journal->publish_at) && !is_null($journal->publish_at))

				{!! Form::text('publish_at',date('Y/m/d', strtotime($journal->publish_at)),['class'=>'datepicker']) !!}
			@else
				{!!Form::text('publish_at','',['class' => 'datepicker']) !!}
			@endif
			 
		{!! Form::div_close() !!}

		{!! Form::div_open('form-group') !!}

			{!! Form::label_custom(Lang::get('admin.journal.create.expect_publish'), 'text-form-large')!!}

			{!! Form::help_block(Lang::get('admin.journal.create.help.expect_publish')) !!}
			
			@if(isset($journal->expect_publish_at) && !is_null($journal->expect_publish_at))

				{!! Form::text('expect_publish_at',date('Y/m/d', strtotime($journal->expect_publish_at)),['class'=>'datepicker']) !!}

			@else
				{!! Form::text('expect_publish_at','',['class'=>'datepicker']) !!}

			@endif
			 
		{!! Form::div_close() !!}
         

	{!! Form::div_close() !!}<!-- end .box-body -->
	
{!! Form::div_close() !!}<!-- /.box box-primary -->


<!-- Upload file -->
{!! Form::div_open('box box-primary') !!}
	<!-- box-header -->
	{!! Form::div_open('box-header padding-box') !!}
		{!! Form::label_custom(Lang::get('admin.journal.create.upload.header'), 'text-form-large')!!}
	{!! Form::div_close() !!}<!-- /.box-header -->	

	
	<!-- box-body -->
	{!! Form::div_open('box-body') !!}

		{!! Form::div_open('form-group') !!}
	
		@if(isset($journal->cover) && ($journal->cover)!="")

			<img src="{!! url('/images/'.$journal->cover) !!}" height="150" width="200">

		@endif	
			{!! Form::file('cover') !!}

		{!! Form::div_close() !!}

	{!! Form::div_close() !!}

{!! Form::div_close() !!}<!-- /.box box-primary -->

	
<!-- Submit	 -->

 {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}
<!-- End form -->
{!! Form::close() !!}

<script>
    $('.datepicker').datepicker({
    	format: "yyyy/mm/dd",
    });
       
</script>

@stop
