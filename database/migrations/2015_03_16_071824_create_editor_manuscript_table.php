<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEditorManuscriptTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('editor_manuscripts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('current_id')->nullable();
			$table->tinyInteger('stage')->nullable();
			$table->integer('manuscript_id');
			$table->integer('user_id');
			$table->integer('loop');
			$table->text('comments');
			$table->tinyInteger('decide')->nullable();
			$table->tinyInteger('section_editor_decide')->nullable();
			$table->integer('editor_suggested_id')->nullable();
			$table->boolean('is_sent')->nullable();
			$table->timestamp('delivery_at');
			$table->timestamp('deadline_at');
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
		Schema::drop('editor_manuscripts');
	}

}
