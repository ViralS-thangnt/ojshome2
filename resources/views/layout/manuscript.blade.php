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
        <div class="box-header">
             <h3 class="box-title">{!! trans('admin.manuscript.title_page_admin') !!}</h3>
        </div><!-- /.box-header -->

        @section('manuscript-detail')

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#manuscript-detail" data-toggle="tab">{!! trans('admin.manuscript.info') !!}</a></li>
                @if (!in_array(REVIEWER, $permissions))
                <li><a href="#manuscript-author" data-toggle="tab">{!! trans('admin.manuscript.author') !!}</a></li>
                @endif
                @if (in_array(CHIEF_EDITOR, $permissions))
                <li><a href="#reviewer" data-toggle="tab">{!! trans('admin.reviewer.comment') !!}</a></li>
                @endif
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="manuscript-detail">
                    <dl>
                        {!! Form::output_text(trans('admin.manuscript.name'), $manuscript->name) !!}
                        {!! Form::output_text(trans('admin.manuscript.type'), $manuscript->type) !!}
                        {!! Form::output_text(trans('admin.manuscript.topic'), $manuscript->topic) !!}
                        {!! Form::output_text(trans('admin.manuscript.summary_vi'), $manuscript->summary_vi) !!}
                        {!! Form::output_text(trans('admin.manuscript.summary_en'), $manuscript->summary_en) !!}
                        {!! Form::output_text(trans('admin.manuscript.keyword_vi'), $manuscript->keyword_vi) !!}
                        {!! Form::output_text(trans('admin.manuscript.keyword_en'), $manuscript->keyword_en) !!}
                        <a href="{!! fileAttachUrl($manuscript->manuscriptFiles, $manuscript->status) !!}">click here to view manuscript detail</a>
                    </dl>
                </div><!-- /.tab-pane -->

                @if (!in_array(REVIEWER, $permissions))
                <div class="tab-pane" id="manuscript-author">
                    <dl>
                        {!! Form::output_text(trans('admin.manuscript.author'), $manuscript->author->full_name) !!}
                    </dl>
                </div><!-- /.tab-pane -->
                @endif

                @if (in_array(CHIEF_EDITOR, $permissions))
                <div class="tab-pane" id="reviewer">
                    @if ($manuscript->currentEditorManuscripts)
                    @foreach ($manuscript->currentEditorManuscripts as $comment)
                    {!! Form::section($comment->user->username, $comment->comments,$comment->decide) !!}
                    @endforeach
                    @endif
                </div><!-- /.tab-pane -->
                @endif
               
            </div><!-- /.tab-content -->
        </div><!--end .nav-tabs-custom -->

        @show

        <div class="box-header">
             <h3 class="box-title">{!! trans('admin.manuscript.editor') !!}</h3>
        </div><!-- /.box-header -->

        @yield('editor')

        <br />

</div><!--end .box-->

@stop
