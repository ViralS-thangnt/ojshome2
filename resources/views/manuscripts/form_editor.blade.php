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

<div class="col-xs-12 col-md-6">
   <div class="box box-solid">

        <div class="box-header">
             <h3 class="box-title">{!! trans('admin.manuscript.header_title') !!}</h3>
        </div><!-- /.box-header -->

        <div class="box-body">
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
        </div><!-- /.box-body -->

    </div><!-- end .box--> 

</div>

<div class="col-xs-12 col-md-6">
    <div class="box box-solid">

        <div class="box-header">
             <h3 class="box-title">{!! trans('admin.manuscript.header_title') !!}</h3>
        </div><!-- /.box-header -->

        <div class="box-body">
            {!! Form::model($manuscript->editorManuscript, ['route' => ['editor.manuscript.update', $manuscript->id, $manuscript->editorManuscript->id], 'id' => 'form-editor-manuscript']) !!}
            
            {!! Form::editor(trans('admin.editorComments'), 'comments', 'comments') !!}
            {!! Form::input_select('decide', trans('decide'), Constant::$decide) !!}

            <input type="hidden" name="is_sent" id="submit-form" />
            <!-- Submit  -->
            {!! Form::button(trans('admin.manuscript.create.submit'), ['class' => 'send btn btn-primary']) !!}
            {!! Form::button(trans('admin.manuscript.create.save'), ['class' => 'btn btn-primary']) !!}

            <script type="text/javascript">
                $(document).ready(function(){
                    $('.btn-primary').click(function(){
                        if ($(this).hasClass('send')) {
                            $('#submit-form').val(1);
                        } else {
                            $('#submit-form').val(0);
                        }

                        $('#form-editor-manuscript').submit();
                    });
                })
            </script>
            {!! Form::close() !!}
        </div><!-- /.box-body -->

    </div><!-- end .box--> 
</div>

@stop
