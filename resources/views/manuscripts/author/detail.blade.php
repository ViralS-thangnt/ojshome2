@extends('layout.manuscriptauthor')

@section('nav-tabs')
@endsection

@section('tab-pane')
@endsection

@section('editor')

{!! Form::model($manuscript->editorManuscript, ['route' => ['editor.manuscript.update-editor', $manuscript->id, $editorManuscript_id]]) !!}

@if (!$disable_edit)
{!! Form::editor('Nhan xet ban bong', 'comments', $disable_edit) !!}
<input type="submit" name="submit" value="Xác nhận" class="btn btn-primary" />
@include('manuscripts.editors.includes.inputhidden')
@endif

{!! Form::close() !!}

@endsection