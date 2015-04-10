<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJournalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('journals', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('name');
			$table->integer('num');
			$table->string('cover');
			$table->dateTime('publish_at');
			$table->dateTime('expect_publish_at')->nullable();
			$table->timestamp('deleted_at')->nullable();
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
		Schema::drop('journals');
	}

}
