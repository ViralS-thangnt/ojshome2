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


<!-- Main content -->
@section('content')
   
    <!-- Author -->
    @if(in_array(AUTHOR, $permissions))
    <div class="box box-primary padding-box">
        {!! Form::title_box_header('Tác giả') !!}

        {!! Form::ul_custom(
                    array_keys(Constant::$author_per), 
                    array_values(Constant::$author_per)
                    ) !!}
    </div>  
    </div>
    @endif

    <!-- Manage editor -->
    @if(in_array(MANAGING_EDITOR, $permissions))
    <div class="box box-primary padding-box">
        {!! Form::title_box_header('Thư ký toà soạn') !!}

        {!! Form::ul_custom(
                    array_keys(Constant::$managing_editor_per), 
                    array_values(Constant::$managing_editor_per)
                    ) !!}
    </div>
    </div>
    @endif

    <!-- Screen editor -->
    @if(in_array(SCREENING_EDITOR, $permissions))
    <div class="box box-primary padding-box">
        {!! Form::title_box_header('Biên tập viên sơ loại') !!}

        {!! Form::ul_custom(
                    array_keys(Constant::$screening_editor_per), 
                    array_values(Constant::$screening_editor_per)
                    ) !!}
    </div>
    </div>
    @endif


    <!-- Section editor -->
    @if(in_array(SECTION_EDITOR, $permissions))
    <div class="box box-primary padding-box">
        {!! Form::title_box_header('Biên tập viên chuyên trách') !!}

        {!! Form::ul_custom(
                    array_keys(Constant::$section_editor_per), 
                    array_values(Constant::$section_editor_per)
                    ) !!}
    </div>
    </div>
    @endif


    <!-- Chief editor -->
    @if(in_array(CHIEF_EDITOR, $permissions))
    <div class="box box-primary padding-box">
        {!! Form::title_box_header('Tổng biên tập') !!}

        {!! Form::ul_custom(
                    array_keys(Constant::$chief_editor), 
                    array_values(Constant::$chief_editor)
                    ) !!}
    </div>
    </div>
    @endif


    <!-- Copy editor -->
    @if(in_array(COPY_EDITOR, $permissions))
    <div class="box box-primary padding-box">
        {!! Form::title_box_header('Biên tập viên bản thảo') !!}

        {!! Form::ul_custom(
                    array_keys(Constant::$copy_editor_per), 
                    array_values(Constant::$copy_editor_per)
                    ) !!}
    </div>
    </div>
    @endif

    <!-- Layout editor -->
    @if(in_array(LAYOUT_EDITOR, $permissions))
    <div class="box box-primary padding-box">
        {!! Form::title_box_header('Biên tập viên chế bản') !!}

        {!! Form::ul_custom(
                    array_keys(Constant::$layout_editor_per), 
                    array_values(Constant::$layout_editor_per)
                    ) !!}
    </div>
    </div>
    @endif


    <!-- Reviewer -->
    @if(in_array(REVIEWER, $permissions))
    <div class="box box-primary padding-box">
        {!! Form::title_box_header('Nhà phản biện') !!}

        {!! Form::ul_custom(
                    array_keys(Constant::$reviewer_per), 
                    array_values(Constant::$reviewer_per)
                    ) !!}
    </div>
    </div>
    @endif

    <!-- Admin -->
    @if(in_array(ADMIN, $permissions))
    <div class="box box-primary padding-box">
        {!! Form::title_box_header('Quản trị') !!}

        {!! Form::ul_custom(
                    array_keys(Constant::$admin_per), 
                    array_values(Constant::$admin_per)
                    ) !!}

    </div>
    </div>
    <!-- /.box-body -->

    @endif
@stop