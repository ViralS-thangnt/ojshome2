<!-- author-dashboard -->
<!-- dashboard.blade.php -->
@extends('layout.master.master')

<!-- Header Title -->
@section('title-page-admin')

Journal Open Source

@stop

<!-- Header Image -->
@section('user-avatar-header')

{!! Form::image_custom('img/avatar3.png', 'Your Image', IMAGE_CIRCLE) !!}

@stop


<!-- Navigation Link -->
@section('navigation-link')
    <!-- Demo Test -->
    <!-- {!! Form::navigate_link(ICON_MENU_SEARCH, 
                                    ['Trang chủ','Editor', 'Gửi bài mới'], 
                                    [url('/admin'), url('/admin/editor'), url('/admin/new-manuscript')]) !!} -->

    {!! Form::navigate_link(ICON_MENU_DASHBOARD) !!}
@stop


<!-- Welcome user -->
@section('avatar-user')

    {!! Form::image_custom('img/avatar3.png', 'User Image', IMAGE_CIRCLE) !!}

@stop

@section('user-welcome')
    <p>Hello, Thang</p>
    <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
@stop


<!-- Page Title -->
@section('title')

Trang chủ

@stop

<!-- Page Title Extra -->
@section('title-extra')

<!-- More extra - Page Title  -->

@stop

<!-- Left column -->
@section('left-column')
{!! getMenuItem($permissions) !!} 
@stop

<!-- Main content -->
@section('content')


    @if(in_array(AUTHOR, $permissions))
    {!! Form::div_open('box box-primary padding-box') !!}
        {!! Form::title_box_header('Tác giả') !!}

        {!! Form::ul_custom(
                [
                    'Gửi bản thảo mới', 
                    'Bản thảo chưa gửi', 
                    'Bản thảo đang sơ loại', 
                    'Bản thảo đang bình duyệt',
                    'Bản thảo đang biên tập',
                    'Bản thảo rút nộp',
                    'Bản thảo bị từ chối',
                    'Bản thảo xuất bản',
                    'Tất cả các bản thảo'
                    ], 
                [
                    url(Constant::$author_per['admin.manuscript.create']), 
                    url('admin/manuscript/unsubmit'), 
                    url('admin/manuscript/in_screening'), 
                    url('admin/manuscript-in-review'), 
                    url('admin/manuscript/in_editing'), 
                    url('admin/manuscript/withdraw'), 
                    url('admin/manuscript/reject'), 
                    url('admin/manuscript/publish'), 
                    url('admin/manuscript/all'), 
                    ]) !!}
    {!! Form::div_close() !!}    
    {!! Form::div_close() !!}
    @endif



    @if(in_array(MANAGING_EDITOR, $permissions))
    {!! Form::div_open('box box-primary padding-box') !!}
        {!! Form::title_box_header('Thư ký toà soạn') !!}

        {!! Form::ul_custom(
                [
                    'Sơ loại', 
                    'Bình duyệt', 
                    'Biên tập', 
                    'Bản thảo bị từ chối',
                    'Bản thảo rút nộp',
                    'Bản thảo xuất bản',
                    'Tất cả các bản thảo'
                    ], 
                [
                    url('admin/manuscript'),
                    url('admin/manuscript/in-review'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    ]) !!}
    {!! Form::div_close() !!}
    {!! Form::div_close() !!}
    @endif




    @if(in_array(SCREENING_EDITOR, $permissions))
    {!! Form::div_open('box box-primary padding-box') !!}
        {!! Form::title_box_header('Biên tập viên sơ loại') !!}

        {!! Form::ul_custom(
                [
                    'Sơ loại', 
                    ], 
                [
                    url('admin/manuscript'),
                    ]) !!}
    {!! Form::div_close() !!}
    {!! Form::div_close() !!}
    @endif



    @if(in_array(SECTION_EDITOR, $permissions))
    {!! Form::div_open('box box-primary padding-box') !!}
        {!! Form::title_box_header('Biên tập viên chuyên trách') !!}

        {!! Form::ul_custom(
                [
                    'Bình duyệt', 
                    'Biên tập', 
                    'Bản thảo bị từ chối', 
                    'Bản thảo rút nộp',
                    'Bản thảo xuất bản',
                    'Tất cả các bản thảo'
                    ], 
                [
                    url('admin/manuscript-in-review'),
                    url('admin/manuscript'), 
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript')
                    ]) !!}
    {!! Form::div_close() !!}
    {!! Form::div_close() !!}
    @endif



    @if(in_array(CHIEF_EDITOR, $permissions))
    {!! Form::div_open('box box-primary padding-box') !!}
        {!! Form::title_box_header('Tổng biên tập') !!}

        {!! Form::ul_custom(
                [
                    'Sơ loại', 
                    'Bình duyệt', 
                    'Biên tập', 
                    'Bản thảo rút nộp',
                    'Bản thảo bị từ chối',
                    'Bản thảo xuất bản',
                    'Tất cả các bản thảo'
                    ], 
                [
                    url('admin/manuscript'),
                    url('admin/manuscript/in-review'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript')
                    ]) !!}
    {!! Form::div_close() !!}
    {!! Form::div_close() !!}
    @endif



    @if(in_array(COPY_EDITOR, $permissions))
    {!! Form::div_open('box box-primary padding-box') !!}
        {!! Form::title_box_header('Biên tập viên bản thảo') !!}

        {!! Form::ul_custom(
                [
                    'Biên tập', 
                    'Bản thảo xuất bản',
                    'Tất cả các bản thảo'
                    ], 
                [
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript')
                    ]) !!}
    {!! Form::div_close() !!}
    {!! Form::div_close() !!}
    @endif


    @if(in_array(LAYOUT_EDITOR, $permissions))
    {!! Form::div_open('box box-primary padding-box') !!}
        {!! Form::title_box_header('Biên tập viên chế bản') !!}

        {!! Form::ul_custom(
                [
                    'Biên tập', 
                    'Bản thảo xuất bản',
                    'Tất cả các bản thảo'
                    ], 
                [
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript')
                    ]) !!}
    {!! Form::div_close() !!}
    {!! Form::div_close() !!}
    @endif



    @if(in_array(REVIEWER, $permissions))
    {!! Form::div_open('box box-primary padding-box') !!}
        {!! Form::title_box_header('Nhà phản biện') !!}

        {!! Form::ul_custom(
                [
                    'Bản thảo chờ phản biện', 
                    'Bản thảo đã phản biện', 
                    'Bản thảo không nhận phản biện',
                    ], 
                [
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript')
                    ]) !!}
    {!! Form::div_close() !!}
    {!! Form::div_close() !!}
    @endif



<!--  -->
    @if(in_array(PRODUCTION_EDITOR, $permissions))
    {!! Form::div_open('box box-primary padding-box') !!}
        {!! Form::title_box_header('Biên tập viên xuất bản') !!}

        {!! Form::ul_custom(
                [
                    'Gửi bản thảo mới', 
                    'Bản thảo chưa gửi', 
                    'Bản thảo đang sơ loại', 
                    'Bản thảo đang bình duyệt',
                    'Bản thảo đang biên tập',
                    'Bản thảo rút nộp',
                    'Bản thảo bị từ chối',
                    'Bản thảo xuất bản',
                    'Tất cả các bản thảo'
                    ], 
                [
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript')
                    ]) !!}
    {!! Form::div_close() !!}
    {!! Form::div_close() !!}
    @endif



    @if(in_array(ADMIN, $permissions))
    {!! Form::div_open('box box-primary padding-box') !!}
        {!! Form::title_box_header('Quản trị') !!}

        {!! Form::ul_custom(
                [
                    'Gửi bản thảo mới', 
                    'Bản thảo chưa gửi', 
                    'Bản thảo đang sơ loại', 
                    'Bản thảo đang bình duyệt',
                    'Bản thảo đang biên tập',
                    'Bản thảo rút nộp',
                    'Bản thảo bị từ chối',
                    'Bản thảo xuất bản',
                    'Tất cả các bản thảo'
                    ], 
                [
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript-in-review'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript'),
                    url('admin/manuscript')
                    ]) !!}

    {!! Form::div_close() !!}
    {!! Form::div_close() !!}<!-- /.box-body -->

    @endif
@stop