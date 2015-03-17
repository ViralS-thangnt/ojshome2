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
						trans('admin.manuscript.create.navigation.create') => url('admin/manuscript')]) !!}

@stop

<!-- Content -->
@section('content')

<!-- form start -->   
{!! Form::model($manuscripts, ['route' => ['manuscript.update', $id], 'enctype' => 'multipart/form-data', 'id' => 'form-manuscript'] ) !!}

<!-- <div class="box box-primary"> -->
{!! Form::div_open('box box-primary padding-box') !!}
	
	<!-- box-header -->
	{!! Form::div_open('box-header') !!}
		{!! Form::h_custom(3, Lang::get('admin.manuscript.create.detail.header'), 'box-title') !!}
	{!! Form::div_close() !!}<!-- /.box-header -->
	
	
	{!! Form::div_open('box-body') !!}
	
		{!! ErrorDisplay::getInstance()->DisplayAll($errors) !!}

		{!! Form::div_open('form-group') !!}

			{!! Form::label_custom(Lang::get('admin.manuscript.create.type'), 'text-form-large', true) !!}

			{!! Form::combobox_custom('type', ['A', 'B', 'C', 'D', 'E', 'F'], 'form-control', false) !!}
			
		{!! Form::div_close() !!}


		{!! Form::div_open('form-group') !!}
			{!! Form::label_custom(Lang::get('admin.manuscript.create.name'), 'text-form-large', true)!!}

			{!! Form::help_block(Lang::get('admin.manuscript.create.help.name')) !!}

			{!! Form::textarea_custom('name', '', 5, Lang::get('admin.manuscript.create.placeholder.name'), 'form-control',
							['onkeyup' => 'countWords(this, 20, 1, "black", "red", "countTopicName")'] ) !!}

			{!! Form::div_open('', 'countTopicName') !!}{!! Form::div_close() !!}
			
		{!! Form::div_close() !!}

		{!! Form::div_open('form-group') !!}
			{!! Form::label_custom(Lang::get('admin.manuscript.create.summary_vi'), 'text-form-large', true)!!}

			{!! Form::help_block(Lang::get('admin.manuscript.create.help.summary_vi')) !!}

			{!! Form::textarea_custom('summary_vi', '', 5, Lang::get('admin.manuscript.create.placeholder.summary_vi'), 'form-control',
							['onkeyup' => 'countWords(this, 200, 150, "black", "red", "countSummaryVn")'] ) !!}
			
			{!! Form::div_open('', 'countSummaryVn') !!}{!! Form::div_close() !!}

		{!! Form::div_close() !!}


		{!! Form::div_open('form-group') !!}
			{!! Form::label_custom(Lang::get('admin.manuscript.create.keyword_vi'), 'text-form-large', true)!!}

			{!! Form::help_block(Lang::get('admin.manuscript.create.help.keyword')) !!}

			{!! Form::combobox_custom('keyword_vi', ['A', 'B', 'C', 'D', 'E', 'F'], 'form-control', true ) !!}
			
		{!! Form::div_close() !!}


		{!! Form::div_open('form-group') !!}
			{!! Form::label_custom(Lang::get('admin.manuscript.create.summary_en'), 'text-form-large', true)!!}

			{!! Form::help_block(Lang::get('admin.manuscript.create.help.summary_en')) !!}

			{!! Form::textarea_custom('summary_en', '', 5, Lang::get('admin.manuscript.create.placeholder.summary_en'), 'form-control',
							['onkeyup' => 'countWords(this, 200, 150, "black", "red", "countSummaryEn")'] ) !!}
			
			{!! Form::div_open('', 'countSummaryEn') !!}{!! Form::div_close() !!}

		{!! Form::div_close() !!}


		{!! Form::div_open('form-group') !!}
			{!! Form::label_custom(Lang::get('admin.manuscript.create.keyword_en'), 'text-form-large', true)!!}

			{!! Form::help_block(Lang::get('admin.manuscript.create.help.keyword')) !!}

			{!! Form::combobox_custom('keyword_en', ['A', 'B', 'C', 'D', 'E', 'F'], 'form-control', true ) !!}
			
		{!! Form::div_close() !!}


		{!! Form::div_open('form-group') !!}
			{!! Form::label_custom(Lang::get('admin.manuscript.create.topic'), 'text-form-large', true)!!}

			{!! Form::textarea_custom('topic', null, 5, Lang::get('admin.manuscript.create.placeholder.topic') ) !!}
			
		{!! Form::div_close() !!}


		{!! Form::div_open('form-group') !!}
			{!! Form::label_custom(Lang::get('admin.manuscript.create.propose_reviewer'), 'text-form-large', false)!!}

			{!! Form::help_block(Lang::get('admin.manuscript.create.help.propose_reviewer')) !!}

			{!! Form::textarea_custom('propose_reviewer', null, 5, Lang::get('admin.manuscript.create.placeholder.propose_reviewer') ) !!}
			
		{!! Form::div_close() !!}

		{!! Form::div_open('form-group') !!}
			{!! Form::label_custom(Lang::get('admin.manuscript.create.expect_journal_id'), 'text-form-large', false)!!}

			{!! Form::help_block(Lang::get('admin.manuscript.create.help.expect_journal_id')) !!}

			{!! Form::textarea_custom('expect_journal_id', null, 1, Lang::get('admin.manuscript.create.placeholder.expect_journal_id') ) !!}
			
		{!! Form::div_close() !!}


		{!! Form::div_open('form-group') !!}
			{!! Form::label_custom(Lang::get('admin.manuscript.create.author_comments'), 'text-form-large', false)!!}

			{!! Form::textarea_custom('author_comments', null, 5, Lang::get('admin.manuscript.create.placeholder.author_comments') ) !!}
			
		{!! Form::div_close() !!}

		

	{!! Form::div_close() !!}<!-- end .box-body -->
	
{!! Form::div_close() !!}<!-- /.box box-primary -->



<!-- Author -->
{!! Form::div_open('box box-primary') !!}
	<!-- box-header -->
	{!! Form::div_open('box-header padding-box') !!}
		{!! Form::h_custom(3, Lang::get('admin.manuscript.create.author.header'), 'box-title') !!}
	{!! Form::div_close() !!}<!-- /.box-header -->

	<!-- box-body -->
	{!! Form::div_open('box-body') !!}

		{!! Form::div_open('form-group') !!}

			{!! Form::label_custom(Lang::get('admin.manuscript.create.co_author'), 'text-form-large', false)!!}

			{!! Form::help_block(Lang::get('admin.manuscript.create.help.co_author')) !!}

			{!! Form::textarea_custom('co_author', null, 5, Lang::get('admin.manuscript.create.placeholder.co_author') ) !!}
		
		{!! Form::div_close() !!}

	{!! Form::div_close() !!}

{!! Form::div_close() !!}<!-- /.box box-primary -->


<!-- Upload file -->
{!! Form::div_open('box box-primary') !!}
	<!-- box-header -->
	{!! Form::div_open('box-header padding-box') !!}
			{!! Form::h_custom(3, trans('admin.manuscript.create.upload.header') . ' <span style="color: red">*</span>' , 'box-title') !!}
	{!! Form::div_close() !!}<!-- /.box-header -->	

	
	<!-- box-body -->
	{!! Form::div_open('box-body') !!}

		{!! Form::div_open('form-group') !!}

			{!! Form::file('file') !!}

		{!! Form::div_close() !!}

	{!! Form::div_close() !!}

{!! Form::div_close() !!}<!-- /.box box-primary -->



<!-- Confirm -->
{!! Form::div_open('box box-primary padding-box') !!}
	<!-- box-header -->
	{!! Form::div_open('box-header') !!}
		{!! Form::h_custom(3, trans('admin.manuscript.create.policy.header') . ' <span style="color: red">*</span>', 'box-title') !!}
		
	{!! Form::div_close() !!}<!-- /.box-header -->

	<!-- box-body -->
	{!! Form::div_open('box-body') !!}

		{!! Form::textarea_custom('policy', null, 20, Lang::get('admin.manuscript.create.placeholder.policy') ) !!}

	{!! Form::div_close() !!}

	{!! Form::div_open('box-body') !!}
		
		{!! Form::ul_custom([Lang::get('admin.manuscript.create.title_policy')]) !!}

		{!! Form::radio('confirm', 1, true, ['class' => 'field']) !!} {!! Lang::get('admin.manuscript.create.policy_yes') !!}
		{!! Form::radio('confirm', 0, ['class' => 'field']) !!} {!! Lang::get('admin.manuscript.create.policy_no') !!}
	{!! Form::div_close() !!}

{!! Form::div_close() !!}<!-- /.box box-primary -->
	
<input type="hidden" name="status" id="submit-form" />
<!-- Submit	 -->
{!! Form::button(trans('admin.manuscript.create.submit'), ['class' => 'send btn btn-primary']) !!}
{!! Form::button(trans('admin.manuscript.create.save'), ['class' => 'btn btn-primary']) !!}

<script type="text/javascript">
	$(document).ready(function(){
		$('.btn-primary').click(function(){
			if ($(this).hasClass('send')) {
				$('#submit-form').val({{IN_SCREENING}});
			} else {
				$('#submit-form').val({{UNSUBMIT}});
			}

			$('#form-manuscript').submit();
		});
	})
</script>

<!-- End form -->
{!! Form::close() !!}
@stop
