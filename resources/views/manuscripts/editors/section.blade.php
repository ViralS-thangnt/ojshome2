@extends('layout.manuscript')

@section('editor')

@section('manuscript-detail')
@parent
@stop



{!! Form::model($manuscript->editorManuscript, ['method' => 'POST', 'route' => ['editor.manuscript.update-editor', $manuscript->id, $editorManuscript_id], 'id' => 'form-editor-manuscript', 'enctype' => 'multipart/form-data']) !!}

<!-- Reviewer and reviewer's comments -->
@if(isset($reviewers_comments) and $reviewers_comments)
<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Phản biện và bình luận</h3>
    </div>
    <div class="box-body">
        <h4>Các nhận xét của nhà phản biện</h4>
        @foreach($reviewers_comments as $value)
            <h4>Nhà phản biện: {{$value['name']}}</h4>
            <h5>Bình luận: {{$value['comments']}}</h5><br />
        @endforeach

    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->
@endif


<div class="box box-primary padding-box">
    <div class="box-body">

    {!! Form::editor(trans('admin.editorComments'), 'comments', $disable_edit, 'ck_editor', isset($section_editor_comments) ? $section_editor_comments['comments'] : null )!!}

    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->


<!-- Upload File -->
<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Upload file</h3>
    </div>
    <div class="box-body">
        {!! Form::file('file') !!}
    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->


<!-- Decide -->
<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Quyết định</h3>
    </div>
    <div class="box-body">
        {!! Form::input_select('decide[]', 'Quyết định đối với bản thảo', array_except(array_merge(Constant::$decide, Constant::$child_decide), NULL ), '', $disable_edit) !!}
        {!! Form::input_select('is_review[]', 'Quyết định thông báo tới Tổng biên tập', array_except(Constant::$notify_chief_editor, NULL ), '', $disable_edit) !!}
    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->


<!-- Buttons  -->
@if (!$disable_edit)
    <!-- send to admin/editor-manuscript/form/{manuscript_id}/{id?} -->
    @include('manuscripts.editors.buttons')
@endif



{!! Form::close() !!}

@stop