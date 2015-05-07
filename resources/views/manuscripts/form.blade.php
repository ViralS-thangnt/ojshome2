@extends('layout.master.master')

@section('title-page-admin')
{!! Lang::get('admin.manuscript.title_page_admin') !!}
@stop

@section('title')
{!! Lang::get('admin.manuscript.manuscript_info')  !!}
@stop

@section('navigation-link')

{!! Form::navigate_link(ICON_MENU_BOOK, [
						trans('admin.manuscript.create.navigation.draft') => url('admin/'), 
						trans('admin.manuscript.create.navigation.create') => url('admin/manuscript/form')]) !!}

@stop

<!-- Content -->
@section('content')



<!-- form start -->  
@if($is_new and !$is_withdrawn)
{!! Form::model($manuscripts, ['method' => 'POST', 'route' => 'manuscript.insert', 'enctype' => 'multipart/form-data', 'id' => 'form-manuscript'] ) !!}
@else
{!! Form::model($manuscripts, ['method' => 'POST', 'route' => ['manuscript.update', $id], 'enctype' => 'multipart/form-data', 'id' => 'form-manuscript'] ) !!}
@endif

<!-- <div class="box box-primary"> -->
<div class="box box-primary padding-box">	

	<!-- box-header -->
	<div class="box-header">	
		{!! Form::h_custom(3, Lang::get('admin.manuscript.create.detail.header'), 'box-title') !!}
	</div><!-- /.box-header -->
	
	<div class="box-body">	
		{!! ErrorDisplay::getInstance()->DisplayAll($errors) !!}

		<!-- Topic Type -->
		<div class="form-group">
			{!! Form::label_custom(Lang::get('admin.manuscript.create.type'), 'text-form-large', true) !!}

			{!! Form::combobox_custom('type', Constant::$manucript_type, 'form-control', false, $disabled) !!}
		</div>


		<!-- Topic Name -->
		<div class="form-group">
			{!! Form::label_custom(Lang::get('admin.manuscript.create.name'), 'text-form-large', true)!!}
			{!! Form::help_block(Lang::get('admin.manuscript.create.help.name')) !!}

			{!! Form::textarea_custom('name', null, 5, Lang::get('admin.manuscript.create.placeholder.name'), 'form-control',
							['onkeyup' => 'countWords(this, 20, 1, "black", "red", "countTopicName")'], $disabled ) !!}

			<div id="countTopicName"></div>
		</div>


		<!-- Summary VN -->
		<div class="form-group">
			{!! Form::label_custom(Lang::get('admin.manuscript.create.summary_vi'), 'text-form-large', true)!!}

			{!! Form::help_block(Lang::get('admin.manuscript.create.help.summary_vi')) !!}

			{!! Form::textarea_custom('summary_vi', null, 5, Lang::get('admin.manuscript.create.placeholder.summary_vi'), 'form-control',
							['onkeyup' => 'countWords(this, 200, 150, "black", "red", "countSummaryVn")'], $disabled ) !!}
			
			<div id="countSummaryVn"></div>
		</div>
		
		<!-- Keyword VN -->
		<div class="form-group">
			{!! Form::label_custom(Lang::get('admin.manuscript.create.keyword_vi'), 'text-form-large', true)!!}
			{!! Form::help_block(Lang::get('admin.manuscript.create.help.keyword')) !!}

			{!! Form::combobox_custom('keyword_vi', $keyword_vi, 'form-control', true, $disabled, $keyword_vi_selected ) !!}
		</div>

		
		<!-- Summary EN -->
		<div class="form-group">
			{!! Form::label_custom(Lang::get('admin.manuscript.create.summary_en'), 'text-form-large', true)!!}
			{!! Form::help_block(Lang::get('admin.manuscript.create.help.summary_en')) !!}

			{!! Form::textarea_custom('summary_en', null, 5, Lang::get('admin.manuscript.create.placeholder.summary_en'), 'form-control',
							['onkeyup' => 'countWords(this, 200, 150, "black", "red", "countSummaryEn")'], $disabled ) !!}
			
			<div id="countSummaryEn"></div>
		</div>

		
		<!-- Keyword EN -->
		<div class="form-group">
			{!! Form::label_custom(Lang::get('admin.manuscript.create.keyword_en'), 'text-form-large', true)!!}
			{!! Form::help_block(Lang::get('admin.manuscript.create.help.keyword')) !!}

			{!! Form::combobox_custom('keyword_en', $keyword_en, 'form-control', true, $disabled, $keyword_en_selected ) !!}
		</div>


		<!-- Topic - Chủ đề bài viết -->
		<div class="form-group">
			{!! Form::label_custom(Lang::get('admin.manuscript.create.topic'), 'text-form-large', true)!!}

			{!! Form::textarea_custom('topic', null, 5, Lang::get('admin.manuscript.create.placeholder.topic'), 'form-control', array(), $disabled ) !!}
		</div>
		

		<!-- Propose Reviewer -->
		<div class="form-group">
			{!! Form::label_custom(Lang::get('admin.manuscript.create.propose_reviewer'), 'text-form-large', false)!!}
			{!! Form::help_block(Lang::get('admin.manuscript.create.help.propose_reviewer')) !!}

			{!! Form::textarea_custom('propose_reviewer', null, 5, Lang::get('admin.manuscript.create.placeholder.propose_reviewer'), 'form-control', array(), $disabled ) !!}
		</div>
		
		<!-- Expect Journal -->
		<div class="form-group">
			{!! Form::label_custom(Lang::get('admin.manuscript.create.expect_journal_id'), 'text-form-large', false)!!}

			{!! Form::help_block(Lang::get('admin.manuscript.create.help.expect_journal_id')) !!}

			{!! Form::textarea_custom('expect_journal_id', null, 1, Lang::get('admin.manuscript.create.placeholder.expect_journal_id'), 'form-control', array(), $disabled ) !!}
			
		</div>

		<!-- Author Comments - Kiến nghị gửi ban biên tập -->
		<div class="form-group">
			{!! Form::label_custom(Lang::get('admin.manuscript.create.author_comments'), 'text-form-large', false)!!}

			{!! Form::textarea_custom('author_comments', null, 5, Lang::get('admin.manuscript.create.placeholder.author_comments'), 'form-control', array(), $disabled ) !!}
		</div>

	</div><!-- end .box-body -->
	
</div><!-- /.box box-primary -->


<!-- Author -->

<div class="box box-primary">

	<!-- box-header -->
	<div class="box-header padding-box">	
		{!! Form::h_custom(3, Lang::get('admin.manuscript.create.author.header'), 'box-title') !!}
	</div><!-- /.box-header -->

	<!-- box-body -->
	<!-- Co-Author -->
	<div class="box-body">
		<div class="form-group">
			{!! Form::label_custom(Lang::get('admin.manuscript.create.co_author'), 'text-form-large', false)!!}
			{!! Form::help_block(Lang::get('admin.manuscript.create.help.co_author')) !!}

			{!! Form::textarea_custom('co_author', null, 5, Lang::get('admin.manuscript.create.placeholder.co_author'), 'form-control', array(), $disabled ) !!}
		</div>
	</div>

</div><!-- /.box box-primary -->

@if(!$disabled)
<!-- Upload file -->
<div class="box box-primary">

	<!-- box-header -->
	<div class="box-header padding-box">	
			{!! Form::h_custom(3, trans('admin.manuscript.create.upload.header') . ' <span style="color: red">*</span>' , 'box-title') !!}
	</div><!-- /.box-header -->	


	<!-- box-body -->
	<div class="box-body">	
		<div class="form-group">
			{!! Form::file('file') !!}
		</div>
	</div>

</div><!-- /.box box-primary -->


<!-- Confirm -->
<div class="box box-primary padding-box">

	<!-- box-header -->
	<div class="box-header">
		{!! Form::h_custom(3, trans('admin.manuscript.create.policy.header') . ' <span style="color: red">*</span>', 'box-title') !!}
		
	</div><!-- /.box-header -->

	<!-- box-body -->
	<div class="box-body">	
		{!! Form::textarea_custom('policy', Lang::get('admin.manuscript.create.policy_content'), 20, 
						Lang::get('admin.manuscript.create.placeholder.policy'), 'form-control', 
						['readonly' => ''], $disabled ) !!}
	</div>

	<div class="box-body">	
		{!! Form::ul_custom([Lang::get('admin.manuscript.create.title_policy')]) !!}

		{!! Form::radio('confirm', 1, true, ['class' => 'field']) !!} {!! Lang::get('admin.manuscript.create.policy_yes') !!}
		{!! Form::radio('confirm', 0, false, ['class' => 'field']) !!} {!! Lang::get('admin.manuscript.create.policy_no') !!}
	</div>

</div><!-- /.box box-primary -->
	
<input type="hidden" name="status" id="submit-form" />
<!-- Submit	 -->

{!! Form::button(trans('admin.manuscript.create.submit'), ['class' => 'send btn btn-primary']) !!}
{!! Form::button(trans('admin.manuscript.create.save'), ['class' => 'draft btn btn-primary']) !!}

@if($need_edit)

		{!! Form::button(trans('admin.withdrawn'), ['class' => 'withdrawn btn btn-primary']) !!}
@endif

@endif

<script type="text/javascript">
	$(document).ready(function(){
		$('.btn-primary').click(function(){
			if ($(this).hasClass('send')) {
				$('#submit-form').val({{IN_SCREENING}});
			} else if ($(this).hasClass('draft')){
				$('#submit-form').val({{UNSUBMIT}});
			} else if ($(this).hasClass('withdrawn')){
				$('#submit-form').val({{REJECTED}});
				$('#form-manuscript').attr("action", "{{ isset($manuscripts->id) ? url(Constant::$url['manuscript.withdrawn'] . '/' . $manuscripts->id) : '' }}");
			}

			$('#form-manuscript').submit();
		});
	})
</script>

<!-- End form -->
{!! Form::close() !!}
@stop
