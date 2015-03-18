<!-- test -->
@extends('layout.master.master')
<!-- Page Title -->
@section('title')
Main Page

@stop

<!-- Main content -->
@section('content')
	<h1> This is main content</h1>
@stop

<!-- Navigation Link -->
@section('navigation-link')

<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li><a href="#">Editor</a></li>
    <li class="active">Main Page</li>
</ol>

@stop

@section('custom-menu')
    <!-- This is create menu demo -->
    {!! Form::menu_item('Thang') !!}
    {!! Form::menu_item(
    				'Menu 1', 
    				4, 
    				array('a', 'b', 'c', 'd'), 
    				['#', url('editor/create'), url('editor/edit'), '48782']) 
    				!!}

@overwrite
