<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManuscriptsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manuscripts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('author_id');
			$table->text('author_comments');
			$table->tinyInteger('type');
			$table->integer('expect_journal_id');
			$table->integer('publish_journal_id');
			$table->string('name');
			$table->text('summary_vi');
			$table->string('keyword_vi');
			$table->string('keyword_en');
			$table->text('summary_en');
			$table->string('topic');
			$table->integer('recommend');
			$table->string('propose_reviewer');
			$table->string('co_author');
			$table->string('file');
			$table->boolean('is_chief_review');
			$table->tinyInteger('chief_decide');
			$table->boolean('is_revise');
			$table->boolean('is_print_out');
			$table->boolean('is_pre_public');
			$table->tinyInteger('status');
			$table->integer('num_public');
			$table->integer('num_page');
			$table->string('file_final');
			$table->dateTime('send_at');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('manuscripts');
	}

}
