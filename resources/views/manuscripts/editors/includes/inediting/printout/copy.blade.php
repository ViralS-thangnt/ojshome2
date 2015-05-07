{!! Form::model($manuscript->editorManuscript, ['route' => ['editor.manuscript.update-editor', $manuscript->id, $editorManuscript_id], 'files' => true]) !!}

@if ($file_download)
	<?php  $url = url(Constant::$url['download-file'] ) . '/' .$file_download->id; ?>
	{!! Form::output_file($file_download->name, $url, $label) !!}
@endif

{!! Form::editor('Nhận xét bản bông', 'comments', $disable_edit) !!}
@include('manuscripts.editors.includes.inputhidden')

<input type="submit" name="submit" value="Submit" class="btn btn-primary" />

{!! Form::close() !!}