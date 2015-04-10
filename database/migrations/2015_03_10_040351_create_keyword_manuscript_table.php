<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateKeywordManuscriptTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('keyword_manuscripts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('manuscript_id');
			$table->integer('keyword_id');
			// $table->timestamp('deleted_at')->nullable();
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
		Schema::drop('keyword_manuscripts');
	}

}
