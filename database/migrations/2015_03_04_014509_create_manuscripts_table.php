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
			$table->integer('editor_id')->nullable();
			$table->integer('section_editor_id')->nullable();
			$table->integer('layout_editor_id')->nullable();
			$table->tinyInteger('file_version')->nullable();
			$table->string('invite_reviewer_ids')->nullable();
			$table->string('reviewer_ids')->nullable();
			$table->string('reject_reviewer_ids')->nullable();
			$table->timestamp('delivery_at');
			$table->timestamp('deadline_at');
			$table->string('current_editor_manuscript_id')->nullable();
			$table->text('author_comments')->nullable();
			$table->tinyInteger('type');
			$table->integer('expect_journal_id')->nullable();
			$table->integer('publish_journal_id')->nullable();
			$table->integer('pre_journal_id')->nullable();
			$table->string('name');
			$table->text('summary_vi');
			$table->text('summary_en')->nullable();
			$table->string('topic');
			$table->integer('recommend')->nullable();
			$table->string('propose_reviewer');
			$table->string('co_author');
			$table->boolean('is_chief_review');
			$table->tinyInteger('chief_decide');
			$table->boolean('is_revise')->nullable();
			$table->boolean('is_print_out')->nullable();
			$table->boolean('is_pre_public')->nullable();
			$table->tinyInteger('status');
			$table->dateTime('send_at')->nullable();
			$table->integer('order')->nullable();
			$table->softDeletes();
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
