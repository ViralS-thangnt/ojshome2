@extends('layout.master.master')

@section('title-page-admin')
{!! Lang::get('admin.manuscript.title_page_admin') !!}
@stop

@section('title')
{!! Lang::get('admin.manuscript.manuscript_info')  !!}
@stop

@section('navigation-link')
@stop

<!-- Content -->
@section('content')

<div class="box box-solid col-xs-12 col-md-12">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#manuscript-detail" data-toggle="tab">Bản thảo</a></li>

                @yield('nav-tabs')

                <li><a href="#manuscript-editor" data-toggle="tab">Biên tập</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="manuscript-detail">
                    @include('manuscripts.author.includes.form')
                </div><!-- /.tab-pane -->

                @yield('tab-pane')
               
                <div class="tab-pane" id="manuscript-editor">
                    {!! ErrorDisplay::getInstance()->DisplayAll($errors) !!}
                    @yield('editor')
                </div><!-- /.tab-pane -->
            </div><!-- /.tab-content -->
        </div><!--end .nav-tabs-custom -->
</div><!--end .box-->

@stop
