@extends('layout.manuscript')

@section('editor')
<script>

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

{!! Form::open() !!}

<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Biên tập viên bản thảo</h3>
    </div>
    <div class="box-body">
    	<h4>Thông tin của biên tập viên bản thảo chịu trách nhiệm cho bản thảo này:</h4>
    	Tên: {{$section_editor->last_name . '  ' . $section_editor->middle_name . '  ' . $section_editor->first_name}}</br>
    	Email: {{$section_editor->email}}</br>
    	Phone: {{$section_editor->phone}}
        
    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->

<div class="box box-primary padding-box">
    <div class="box-header padding-box">
        <h3 class="box-title">Tải về file bản thảo</h3>
    </div>
    <div class="box-body">
        
        Đây là file bản thảo đã được biên tập viên chế bản chỉnh sửa theo dạng khuôn in PDF: </br></br>
        
        <a href="#" onclick="javascript: return downloadFile();"> Download file của bản thảo của biên tập viên chế bản gửi lên</a>
        
    </div>  <!-- end box-body -->
</div>  <!-- end box-primary -->


{!! Form::close() !!}




@stop








