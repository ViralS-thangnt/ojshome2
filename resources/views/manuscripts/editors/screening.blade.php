@extends('layout.manuscript')

@section('editor')
{!! Form::model($manuscript->editorManuscript, ['route' => ['editor.manuscript.update-editor', $manuscript->id, $editorManuscript_id], 'id' => 'form-editor-manuscript']) !!}


<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Đề xuất nhà phản biện</h3>
    </div>
    <div class="box-body">
        @if (isset($reviewers))
            {!! Form::input_select('editor_suggested_id', 'Chọn nhà phản biện', $reviewers, '', $disable_edit) !!}
        @endif

    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->


<div class="box box-primary padding-box">
    <div class="box-body">
    {!! Form::editor(trans('admin.editorComments'), 'comments', $disable_edit, 'ck_editor', isset($section_editor_comments) ? '<pre>' . $section_editor_comments['comments'] . '</pre>' : null )!!}
    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->


<!-- Decide -->
<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Quyết định</h3>
    </div>
    <div class="box-body">
        {!! Form::input_select('decide[]', 'Quyết định đối với bản thảo', array_except(array_merge(Constant::$decide, Constant::$child_decide), NULL ), '', $disable_edit) !!}
    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->


<!-- Buttons  -->
<!-- send to admin/editor-manuscript/form/{manuscript_id}/{id?} -->
@if (!$disable_edit)
    @include('manuscripts.editors.buttons')
@endif



{!! Form::close() !!}
@stop

