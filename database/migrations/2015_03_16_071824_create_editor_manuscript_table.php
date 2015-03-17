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

			$table->tinyInteger('stage');
			$table->integer('manuscript_id');
			$table->integer('user_id');
			$table->integer('loop');
			$table->text('comments');
			$table->tinyInteger('decide');
			$table->integer('editor_suggested_id');
			$table->string('file');
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
