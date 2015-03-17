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
<<<<<<< HEAD
			$table->integer('editor_id');
			$table->integer('section_editor_id');
			$table->integer('loop');
			$table->text('author_comments');
=======
			$table->text('author_comments')->nullable();
>>>>>>> a61e5668a3180565a8d4bd34fce5ebd154682b17
			$table->tinyInteger('type');
			$table->integer('expect_journal_id')->nullable();
			$table->integer('publish_journal_id')->nullable();
			$table->string('name');
			$table->text('summary_vi');
			$table->string('keyword_vi');
			$table->string('keyword_en')->nullable();
			$table->text('summary_en')->nullable();
			$table->string('topic');
			$table->integer('recommend');
			$table->string('propose_reviewer');
			$table->string('co_author');
			$table->string('file');
			$table->boolean('is_chief_review');
			$table->tinyInteger('chief_decide');
			$table->boolean('is_revise')->nullable();
			$table->boolean('is_print_out')->nullable();
			$table->boolean('is_pre_public')->nullable();
			$table->tinyInteger('status');
<<<<<<< HEAD
			$table->integer('num_public');
			$table->integer('num_page');
			$table->string('file_final');
			$table->string('file_page');
			$table->string('publish_pre_no');
			$table->dateTime('send_at');
=======
			$table->integer('num_public')->nullable();
			$table->integer('num_page')->nullable();
			$table->string('file_final')->nullable();
			$table->dateTime('send_at')->nullable();
>>>>>>> a61e5668a3180565a8d4bd34fce5ebd154682b17
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
