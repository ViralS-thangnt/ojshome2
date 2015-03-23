<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManuscriptFilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('manuscript_files', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('manuscript_id');
			$table->integer('user_id');
			$table->string('name');
			$table->tinyInteger('type');
			$table->integer('total_page')->nullable();
			$table->string('extension', 50)->nullable();

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
		Schema::drop('manuscript_files');
	}

}
