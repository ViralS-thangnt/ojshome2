@extends('layout.manuscript')

@section('nav-tabs')

{{-- Khi ban thao da che ban xong, btv che ban co the xem cac nhan xet ban bong --}}
@if (!is_null($manuscript->is_print_out))
<li><a href="#comments-printout" data-toggle="tab">Nhận xét bản bông</a></li>
@endif

@stop

@section('tab-pane')

<div class="tab-pane" id="comments-printout">

{{-- Neu co nhan xet ban bong cua btv ban thao --}}
@if (isset($copyeditor_comment) && !is_null($copyeditor_comment))
{!! Form::section('Nhận xét của biên tập viên bản thảo', $copyeditor_comment->comments) !!}
@endif

{{-- Neu co nhan xet ban bong cua tac gia --}}
@if (isset($author_comment) && !is_null($author_comment))
{!! Form::section('Nhận xét của tác giả', $author_comment->comments) !!}
@endif

</div><!-- end #comments-printout-->

@stop

@section('editor')

{!! Form::model($manuscript, ['route' => ['editor.manuscript.update-editor', $manuscript->id], 'files' => true]) !!}
<?php 
if(isset($file_download->type))
{
	$title = ($file_download->type == LAYOUT_PRINT_FILE) ? 'Tải xuống bản thảo chế bản' : 'Tải xuống bản thảo hiệu đính'; 
	$url = url(Constant::$url['download-file'] ) . '/' .$file_download->id;
}

?>

@if ($file_download)
    {!! Form::output_file($file_download->name, $url, $title) !!}
@endif

{{-- Giai doan che ban --}}
@if (is_null($manuscript->is_print_out))
    {!! Form::input_file('file', 'Tải lên file chế bản') !!}
    {!! Form::hidden('is_print_out', 1) !!}
{{-- Giai doan ket thuc kiem bong --}}
@else
    {!! Form::input_file('file', 'Tải lên file sơ bản') !!}
    {!! Form::hidden('is_pre_public', 1) !!}
@endif
<input type="submit" name="submit" value="Xác nhận" class="btn btn-primary" />
{!! Form::close() !!}
@stop