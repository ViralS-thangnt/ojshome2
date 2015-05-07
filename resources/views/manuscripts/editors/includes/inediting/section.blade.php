{!! Form::model($manuscript, ['route' => ['editor.manuscript.update-editor', $manuscript->id], 'id' => 'form-editor-manuscript']) !!}
{!! Form::input_select('editor_id', 'Chọn biên tập viên bản thảo', $copy_editors, '', $disable_edit) !!}

{!! Form::input_select('file_version', 'Chọn phiên bản bản thảo', Constant::$file_version, '', $disable_edit) !!}

@if (!$disable_edit)
<input type="submit" name="submit" value="Save" class="btn btn-primary" />
@endif

{!! Form::close() !!}