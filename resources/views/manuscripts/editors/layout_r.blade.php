@extends('layout.manuscript')

@section('editor')

<script>

    $(document).ready(function(){
        $("form").submit(function(event){

            if(document.getElementById("file").value == "") {
                alert("Bạn chưa upload file chế bản");
                event.preventDefault();
            }
            else {
                var fullPath = document.getElementById("file").value;

                if (fullPath) {
                    var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                    var filename = fullPath.substring(startIndex);
                    if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) {
                        filename = filename.substring(1);
                    }
                    var arr = filename.split(".");

                    if(arr[arr.length - 1].toUpperCase() != "PDF"){
                        alert("Bạn phải upload file với định dạng khuôn in PDF !");
                        event.preventDefault();
                    }
                    else {
                        if(!confirm('Bạn có chắc chắn muốn gửi bài ? ')) {
                            
                            event.preventDefault();
                        }
                    }
                }
            }
        });
    });

    function downloadFile()
    {
        if( confirm('Bạn muốn tải xuống file bản thảo ?'))
        {
            window.open("{!! url(Constant::$url['download-file'] ) . '/' . $layout_editor_file_id !!}", "download");

            return true;    // Download Success
        }

        return false;    
    }

</script>

{!! Form::model($manuscript->editorManuscript, ['route' => ['editor.manuscript.update-editor', $manuscript->id, $editorManuscript_id], 'id' => 'form-editor-manuscript', 'file' => true, 'enctype' => 'multipart/form-data']) !!}

<!-- Copy Editor Info -->
<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Tải về file bản thảo</h3>
    </div>
    <div class="box-body">
        
        <h4>Thông tin của biên tập viên bản thảo chịu trách nhiệm cho bản thảo này:</h4>
        Tên: <pre>{{$copy_editor->last_name . '  ' . $copy_editor->middle_name . '  ' . $copy_editor->first_name}}</pre></br>
        Email: <pre>{{$copy_editor->email}}</pre></br>
        Phone: <pre>{{$copy_editor->phone}}</pre>
        
    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->




@if($manuscript->is_pre_public == NOT_PRE_PUBLIC)

<!-- Giai đoạn chế bản -->
<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Tải về file bản thảo</h3>
    </div>
    <div class="box-body">
        
            File của biên tập viên bản thảo</br></br>
            
            <a href="#" onclick="javascript: return downloadFile();"> Download file bản thảo đã hiệu đính của biên tập viên bản thảo</a>
        
    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->


<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Tải lên file chế bản</h3>
    </div>
    <div class="box-body">
        File phải có dạng khuôn in PDF </br></br>
        {!! Form::file('file', ['id' => 'file', ($disable_edit) ? 'disabled' : '']) !!}

    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->

{!! Form::hidden('is_print_out', 1) !!}



@else
<!-- Giai đoạn kiểm bông -->

<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Tải về file bản thảo </h3>
    </div>
    <div class="box-body">
        
            File PDF dưới dạng khuôn in đã upload lên</br></br>
            
            <a href="#" onclick="javascript: return downloadFile();"> Download file bản thảo dưới dạng khuôn in PDF</a>
        
    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->

<!-- Comments -->
<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Nhận xét bản bông của biên tập viên bản thảo</h3>
    </div>

    <div class="box-body">
    {!! Form::editor(trans('admin.editorComments'), 'comments', true, 'ck_editor', isset($copy_editor_comments) ? '<pre>' . $copy_editor_comments->comments . '</pre>' : null )!!}
    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->


<!-- Submit form sẽ bắt đầu giai đoạn PUBLISHING -->
{!! Form::hidden('start_publish', START_PUBLISH) !!}

{!! Form::button(trans('admin.manuscript.create.submit'), ['class' => 'send btn btn-primary', 'type' => 'submit']) !!}

@endif

{!! Form::hidden('stage', $stage) !!}
{!! Form::hidden('loop', $loop) !!}
{!! Form::hidden('current_id', $current_id) !!}
{!! Form::hidden('is_pre_public', PRE_PUBLIC) !!}




{!! Form::close() !!}
@stop