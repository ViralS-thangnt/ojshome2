<!-- author-dashboard -->
<!-- dashboard.blade.php -->
@extends('layout.master.master')

<!-- Header Title -->
@section('title-page-admin')

Journal Open Source

@stop

<!-- Header Image -->
@section('user-avatar-header')

{!! Form::image_custom(url('assets/img/avatar3.png'), 'Your Image', IMAGE_CIRCLE) !!}

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

    {!! Form::image_custom(url('assets/img/avatar3.png'), 'User Image', IMAGE_CIRCLE) !!}

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
    
    <!-- Author -->
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
                    url(Constant::$author_per['admin.manuscript.unsubmit']), 
                    url(Constant::$author_per['admin.manuscript.inScreening']), 
                    url(Constant::$author_per['admin.manuscript.inReview']), 
                    url(Constant::$author_per['admin.manuscript.inEditing']), 
                    url(Constant::$author_per['admin.manuscript.withdrawn']),  
                    url(Constant::$author_per['admin.manuscript.rejected']), 
                    url(Constant::$author_per['admin.manuscript.published']), 
                    url(Constant::$author_per['admin.manuscript.all']), 
                    ]) !!}
    {!! Form::div_close() !!}    
    {!! Form::div_close() !!}
    @endif

    <!-- Manage editor -->
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
                    url(Constant::$author_per['admin.manuscript.inScreening']),
                    url(Constant::$author_per['admin.manuscript.inReview']), 
                    url(Constant::$author_per['admin.manuscript.inEditing']), 
                    url(Constant::$author_per['admin.manuscript.rejected']),
                    url(Constant::$author_per['admin.manuscript.withdrawn']),  
                    url(Constant::$author_per['admin.manuscript.published']), 
                    url(Constant::$author_per['admin.manuscript.all']), 
                    ]) !!}
    {!! Form::div_close() !!}
    {!! Form::div_close() !!}
    @endif

    <!-- Screen editor -->
    @if(in_array(SCREENING_EDITOR, $permissions))
    {!! Form::div_open('box box-primary padding-box') !!}
        {!! Form::title_box_header('Biên tập viên sơ loại') !!}

        {!! Form::ul_custom(
                [
                    'Sơ loại', 
                    ], 
                [
                    url(Constant::$author_per['admin.manuscript.inScreening']), 
                    ]) !!}
    {!! Form::div_close() !!}
    {!! Form::div_close() !!}
    @endif


    <!-- Section editor -->
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
                    url(Constant::$author_per['admin.manuscript.inReview']), 
                    url(Constant::$author_per['admin.manuscript.inEditing']), 
                    url(Constant::$author_per['admin.manuscript.rejected']), 
                    url(Constant::$author_per['admin.manuscript.withdrawn']),  
                    url(Constant::$author_per['admin.manuscript.published']), 
                    url(Constant::$author_per['admin.manuscript.all']), 
                    ]) !!}
    {!! Form::div_close() !!}
    {!! Form::div_close() !!}
    @endif


    <!-- Chief editor -->
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
                    url(Constant::$author_per['admin.manuscript.inScreening']), 
                    url(Constant::$author_per['admin.manuscript.inReview']), 
                    url(Constant::$author_per['admin.manuscript.inEditing']),
                    url(Constant::$author_per['admin.manuscript.withdrawn']),
                    url(Constant::$author_per['admin.manuscript.rejected']), 
                    url(Constant::$author_per['admin.manuscript.published']), 
                    url(Constant::$author_per['admin.manuscript.all']), 
                    ]) !!}
    {!! Form::div_close() !!}
    {!! Form::div_close() !!}
    @endif


    <!-- Copy editor -->
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
                    url(Constant::$author_per['admin.manuscript.inEditing']),
                    url(Constant::$author_per['admin.manuscript.published']), 
                    url(Constant::$author_per['admin.manuscript.all']), 
                    ]) !!}
    {!! Form::div_close() !!}
    {!! Form::div_close() !!}
    @endif

    <!-- Layout editor -->
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
                    url(Constant::$author_per['admin.manuscript.inEditing']),
                    url(Constant::$author_per['admin.manuscript.published']), 
                    url(Constant::$author_per['admin.manuscript.all']), 
                    ]) !!}
    {!! Form::div_close() !!}
    {!! Form::div_close() !!}
    @endif


    <!-- Reviewer -->
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
                    url(Constant::$reviewer_per['admin.manuscript.waitReview']),
                    url(Constant::$reviewer_per['admin.manuscript.unReview']),
                    url(Constant::$reviewer_per['admin.manuscript.reviewed']),
                    ]) !!}
    {!! Form::div_close() !!}
    {!! Form::div_close() !!}
    @endif

    <!-- Admin -->
    @if(in_array(ADMIN, $permissions))
    {!! Form::div_open('box box-primary padding-box') !!}
        {!! Form::title_box_header('Quản trị') !!}

        {!! Form::ul_custom(
                [
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
                    url(Constant::$author_per['admin.manuscript.unsubmit']), 
                    url(Constant::$author_per['admin.manuscript.inScreening']), 
                    url(Constant::$author_per['admin.manuscript.inReview']), 
                    url(Constant::$author_per['admin.manuscript.inEditing']), 
                    url(Constant::$author_per['admin.manuscript.withdrawn']),  
                    url(Constant::$author_per['admin.manuscript.rejected']), 
                    url(Constant::$author_per['admin.manuscript.published']), 
                    url(Constant::$author_per['admin.manuscript.all']), 
                    ]) !!}

    {!! Form::div_close() !!}
    {!! Form::div_close() !!}<!-- /.box-body -->

    @endif
@stop