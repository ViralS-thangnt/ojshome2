@extends('layout.manuscript')

@section('editor')
@if (!$rejected_user)
    {!! Form::model($manuscript->editorManuscript, ['route' => ['editor.manuscript.update-editor', $manuscript->id, $editorManuscript_id], 
    'id' => 'form-editor-manuscript', 'files' => true, 'enctype' => 'multipart/form-data']) !!}
    {!! Form::editor(trans('admin.reviewerComments'), 'comments', $disable_edit) !!}
    @if (!$disable_edit)
    {!! Form::file('file') !!}
    @endif
    {!! Form::input_select('decide', trans('decide'), array_merge(Constant::$decide, Constant::$child_decide), '', $disable_edit) !!}
    {!! Form::hidden('stage', $stage) !!}
    {!! Form::hidden('loop', $loop) !!}
    {!! Form::hidden('current_id', $current_id) !!}
    @if (!$disable_edit)
    @include('manuscripts.editors.buttons')
    @endif
    {!! Form::close() !!}
@endif
@stop