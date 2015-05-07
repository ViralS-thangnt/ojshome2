{!! Form::model($manuscript, ['route' => ['editor.manuscript.update-editor', $manuscript->id], 'files' => true]) !!}

@if ($file_download)
  <?php  $url = url(Constant::$url['download-file'] ) . '/' .$file_download->id; ?>
  {!! Form::output_file($file_download->name, $url, $label) !!}
@endif

@if (is_null($manuscript->is_revise))
  {!! Form::input_file('file', 'Tải lên file hiệu đính') !!}
  {!! Form::input_select('layout_editor_id', 'Chọn biên tập viên chế bản', $layout_editors) !!}
  {!! Form::hidden('is_revise', 1) !!}
  <input type="submit" name="submit" value="Hiệu đính" class="btn btn-primary" />
@endif

{!! Form::close() !!}