<input type="hidden" name="is_sent" id="is_sent" />
<!-- Submit  -->
{!! Form::button(trans('admin.manuscript.create.submit'), ['class' => 'send btn btn-primary']) !!}

@if (in_array(REVIEWER, $permissions) || in_array(SCREENING_EDITOR, $permissions))
{!! Form::button(trans('admin.manuscript.create.save'), ['class' => 'btn btn-primary']) !!}
@endif

@if (in_array(REVIEWER, $permissions) && $editorManuscript_id == '')
{!! Form::button(trans('admin.rejected'), ['class' => 'rejected btn btn-primary']) !!}
<input type="hidden" name="rejected" id="rejected" />
@endif

<script type="text/javascript">
    $(document).ready(function(){
        $('.btn-primary').click(function(){
            if ($(this).hasClass('send')) {
                $('#is_sent').val(1);
            } else if ($(this).hasClass('rejected')) {
                if (confirm('Are you sure you want to reject this manuscript?')) {
                    $('#rejected').val(1);
                    $('#is_sent').val(0);
                } else {
                    return false;
                }
            } else {
                $('#is_sent').val(0);
            }

            $('#form-editor-manuscript').submit();
        });
    })
</script>