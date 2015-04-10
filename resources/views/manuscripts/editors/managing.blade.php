@extends('layout.manuscript')

@section('editor')

@section('manuscript-detail')
@parent
@stop

{!! Form::model($manuscript->editorManuscript, ['route' => ['editor.manuscript.update', $manuscript->id, $editorManuscript_id], 'id' => 'form-editor-manuscript', 'enctype' => 'multipart/form-data']) !!}


<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Biên tập viên sơ loại </h3>
    </div>
    <div class="box-body">

        @if(isset($screening_editors_info) and $screening_editors_info)
            
            Tên: {{$screening_editors_info['name']}}</br>

            Vòng: {{isset($screening_editors_info['loop']) ? $screening_editors_info['loop'] : '----'}}</br>
            
            Bình luận: {{isset($screening_editors_info['comments']) ? $screening_editors_info['comments'] : '----'}}</br>
        @else
            Không có thông tin của biên tập viên sơ loại
        @endif
    </div>  <!-- end box-body -->

</div>  <!-- end box-primary -->


<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Thông tin các nhà phản biện </h3>
    </div>
    <div class="box-body">
        {!! Form::output_list(trans('admin.reviewed.reviewers.list'), ($reviewed_list) ? $reviewed_list : array()) !!}

        {!! Form::output_list(trans('admin.reject.reviewers.list'), ($reject_list) ? $reject_list : array()) !!}

        {!! Form::output_list(trans('admin.invite.reviewers.list'), ($invite_list) ? $invite_list : array()) !!}
    </div>  <!-- end box-body -->

</div>  <!-- end box-primary -->


@if (isset($screening_editors))

<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Lựa chọn BTV sơ loại </h3>
    </div>
    <div class="box-body">
            {!! Form::hidden('manuscript_id', $manuscript->id) !!} 
            {!! Form::hidden('ass_scr_editor', 1) !!} 
            {!! Form::input_select('editor_id', 'Screening Editor', $screening_editors, '', $disable_edit) !!}
            @if (!$disable_edit)
                {!! Form::button(trans('admin.manuscript.assign'), ['class' => 'btn btn-primary', 'id' => 'assign-screening']) !!}
            @endif
               
    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->

<input type="submit" value="Gui bai" />

@endif


@if (isset($section_editors))

<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Lựa chọn BTV chuyên trách </h3>
    </div>
    <div class="box-body">
        {!! Form::input_select('section_editor_id', 'Section Editor', $section_editors, '', $disable_edit) !!}
        @if (!$disable_edit)
            {!! Form::button(trans('admin.manuscript.assign'), ['class' => 'btn btn-primary', 'id' => 'assign-section']) !!}
        @endif
    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->

    
@endif
@if (isset($reviewers))
<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Lựa chọn Nhà phản biện</h3>
    </div>
    <div class="box-body">
        {!! Form::multi_select('invite_reviewer_ids', 'Reviewer', $reviewers, '') !!}
        {!! Form::date_pick('deadline', 'Dealine') !!}
        {!! Form::button(trans('admin.manuscript.assign'), ['class' => 'btn btn-primary', 'id' => 'assign-reviewers']) !!}
            
    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->
    
@endif


<script type="text/javascript">
    $(document).ready(function(){
        $('.btn-primary').click(function(){
            var sent_data = 'manuscript_id=' + {{$manuscript->id}} + '&';
            var message;
            var condition;
            switch($(this).attr('id')) {
                case 'assign-screening':
                    condition = ($('#editor_id').val() == null);
                    message = '{{trans('admin.manuscript.alertSelectScreeningEditor')}}';
                    sent_data += 'editor_id=' + $('#editor_id').val() + 'stage' + $('#stage').val();
                    break;
                case 'assign-section':
                    condition = ($('#section_editor_id').val() == null);
                    message = '{{trans('admin.manuscript.alertSelectSectionEditor')}}';
                    sent_data += 'section_editor_id=' + $('#section_editor_id').val();
                    break;
                case 'assign-reviewers':
                    condition = ($('#invite_reviewer_ids').val() == null || $('#deadline').val() == '');
                    message = '{{trans('admin.manuscript.alertSelectReviewers')}}';
                    sent_data += 'reviewer_ids=' + $('#invite_reviewer_ids').val() + '&reviewer_names=' + $('#invite_reviewer_ids option:selected').text() + '&deadline=' + $('#deadline').val();
                    break;
            }

            if (condition) {
                alert(message);

                return false;
            }
            
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': {!! json_encode(csrf_token()) !!},
                },
                url: "{!! url('manuscript-update') !!}",
                type: 'post',
                data: sent_data,
                success: function(response) {
                    alert(response);
                }
            });
        });

        $('.chosen-select').chosen();
    })
</script>

{!! Form::close() !!}

@stop