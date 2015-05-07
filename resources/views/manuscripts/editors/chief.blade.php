@extends('layout.manuscript')

@section('nav-tabs')

<li><a href="#reviewer" data-toggle="tab">{!! trans('admin.reviewer.comment') !!}</a></li>

@endsection

@section('tab-pane')
<div class="tab-pane" id="reviewer">
    @if (!$manuscript->currentEditorManuscripts->isEmpty())

    @foreach ($manuscript->currentEditorManuscripts as $comment)

    	@if(!empty($comment->user))
    		{!! Form::section($comment->user->username, $comment->comments,$comment->decide) !!}
    	@endif
    	
    @endforeach
    @endif

</div><!-- /.tab-pane -->

@endsection

@section('editor')

@if ($manuscript->status == IN_EDITING)

{!! Form::model($manuscript->editorManuscript, ['route' => ['editor.manuscript.update', $manuscript->id, $editorManuscript_id], 'id' => 'form-editor-manuscript', 'files' => true]) !!}

{!! Form::editor(trans('admin.editorComments'), 'comments', $disable_edit) !!}
{!! Form::input_select('pre_journal_id', 'Tạp chí sơ xếp', $journals, $disable_edit) !!}
{!! Form::input_select('decide', trans('decide'), Constant::$full_decide, '', $disable_edit) !!}

@include('manuscripts.editors.includes.inputhidden')
@include('manuscripts.editors.buttons')

@endif
{!! Form::close() !!}

@stop