@extends('layout.manuscript')

@section('editor')

@section('manuscript-detail')
@parent
@stop
{!! Form::model($manuscript->editorManuscript, ['route' => ['editor.manuscript.update', $manuscript->id, $editorManuscript_id], 'id' => 'form-editor-manuscript', 'enctype' => 'multipart/form-data']) !!}

{!! Form::editor(trans('admin.editorComments'), 'comments', $disable_edit) !!}
{!! Form::input_select('decide', trans('decide'), Constant::$full_decide, '', $disable_edit) !!}
{!! Form::hidden('stage', $stage) !!}
{!! Form::hidden('loop', $loop) !!}
{!! Form::hidden('current_id', $current_id) !!}
@include('manuscripts.editors.buttons')
<script type="text/javascript">
    $(document).ready(function(){
    
    })
</script>

{!! Form::close() !!}

@stop