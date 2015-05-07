@extends('layout.manuscript')

@section('editor')

<script>

    $(document).ready(function(){
        $("form").submit(function(event){
            // alert(document.getElementById("file").value);
            if(!confirm('Bạn có chắc chắn muốn gửi bài ? '))
            {
                
                event.preventDefault();
            }
        });
    });

    function downloadFile()
    {
        if(confirm('Bạn muốn tải xuống file bản thảo ?'))
        {
            window.open("{!! url(Constant::$url['download-file'] ) . '/' . $layout_print_file_id !!}", "download");

            return true;    // Download Success
        }

        return false;    
    }

</script>

{!! Form::model($manuscript->editorManuscript, ['route' => ['editor.manuscript.update-editor', $manuscript->id, $editorManuscript_id], 'id' => 'form-editor-manuscript', 'file' => true]) !!}



@if($manuscript->is_pre_public == PRE_PUBLIC)

<!-- Giai đoạn kiểm bông -->
<!-- Thông tin layout editor -->
<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Thông tin biên tập viên chế bản </h3>
    </div>
    <div class="box-body">
        <h4>Thông tin của biên tập viên chế bản chịu trách nhiệm chỉnh sửa bản thảo này:</h4>
        @if($layout_editor)
            Tên: <pre>{{$layout_editor->last_name . '  ' . $layout_editor->middle_name . '  ' . $layout_editor->first_name}}</pre></br>
            Email: <pre>{{$layout_editor->email}}</pre></br>
            Phone: <pre>{{$layout_editor->phone}}</pre>

        @else

            Không có thông tin của biên tập viên chế bản này

        @endif
        

    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->

<!-- Download file -->
<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Tải về file bản thảo </h3>
    </div>
    <div class="box-body">

        Đây là file bản thảo đã được biên tập viên chế bản chỉnh sửa theo dạng khuôn in PDF: </br></br>
        <a href="#" onclick="javascript: return downloadFile();"> Download file của bản thảo của biên tập viên chế bản gửi lên</a>

    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->

<!-- Comments -->
<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Nhận xét bản bông</h3>
    </div>

    <div class="box-body">
    {!! Form::editor(trans('admin.editorComments'), 'comments', false, 'ck_editor', isset($copy_editor_comments) ? '<pre>' . $copy_editor_comments['comments'] . '</pre>' : null )!!}
    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->


@include('manuscripts.editors.buttons')

{!! Form::hidden('is_layout_print_comment', 1) !!}

@else

<!-- Giai đoạn giao bản thảo cho BTV chế bản (Layout Editor) -->
<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Tải về file bản thảo</h3>
    </div>
    <div class="box-body">
        
            Đây là file bản thảo gốc của tác giả gửi lên:</br></br>
            
            <a href="#" onclick="javascript: return downloadFile();"> Download file bản thảo gốc của tác giả</a>
        
    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->


<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Tải lên file chế bản</h3>
    </div>
    <div class="box-body">
       {!! Form::file('file', ['id' => 'file', ($disable_edit) ? 'disabled' : '']) !!}

    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->
<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Chọn biên tập viên chế bản</h3>
    </div>
    <div class="box-body">
       {!! Form::input_select('layout_editor_id', 'Layout Editor', $layout_editors, '', $disable_edit) !!}

    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->


{!! Form::hidden('stage', $stage) !!}
{!! Form::hidden('loop', $loop) !!}
{!! Form::hidden('current_id', $current_id) !!}
{!! Form::hidden('is_revise', 1) !!}

@if (!$disable_edit)
    @include('manuscripts.editors.buttons')
@endif

<!-- End check PRINT_OUT  -->
@endif


{!! Form::close() !!}
@stop
