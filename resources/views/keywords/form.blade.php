@extends('layout.master.master')

<!-- Left column -->
@section('left-column')
{!! getMenuItem($permissions) !!} 
@stop

@section('title-page-admin')
{!! Lang::get('admin.keyword.title') !!}
@stop

@section('title')
{!! Lang::get('admin.keyword.keyword_info')  !!}
@stop

@section('navigation-link')

{!! Form::navigate_link(ICON_MENU_BOOK, [
						trans('admin.keyword.create.navigation.keyword') => url('admin/keyword'), 
						trans('admin.keyword.create.navigation.create') => url('admin/keyword/form')]) !!}

@stop

<!-- Content -->
@section('content')

<!-- form start -->  
{!! Form::model($keyword, ['route' => ['keyword.update', $id], 'enctype' => 'multipart/form-data', 'id' => 'form-manuscript'] ) !!}

<!-- <div class="box box-primary"> -->
{!! Form::div_open('box box-primary padding-box') !!}
	
	<!-- box-header -->
	{!! Form::div_open('box-header') !!}
		{!! Form::h_custom(3, Lang::get('admin.detail'), 'box-title') !!}
	{!! Form::div_close() !!}<!-- /.box-header -->
	
	
	{!! Form::div_open('box-body') !!}
	
		{!! ErrorDisplay::getInstance()->DisplayAll($errors) !!}

		{!! Form::div_open('form-group') !!}

			{!! Form::label_custom(Lang::get('admin.keyword.create.type'), 'text-form-large', true) !!}

			{!! Form::select('lang_code', Constant::$keyword_type, null, ['class'=>'form-control']) !!}
			
		{!! Form::div_close() !!}

		{!! Form::div_open('form-group') !!}
			{!! Form::label_custom(Lang::get('admin.keyword.create.name'), 'text-form-large', true)!!}

			{!! Form::textarea_custom('text', null, 5, Lang::get('admin.keyword.create.placeholder.name'), 'form-control') !!}
			
		{!! Form::div_close() !!}
		

	{!! Form::div_close() !!}<!-- end .box-body -->
	
{!! Form::div_close() !!}<!-- /.box box-primary -->
	
<!-- Submit	 -->

{!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}

<!-- End form -->
{!! Form::close() !!}
@stop