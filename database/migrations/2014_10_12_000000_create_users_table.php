<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->tinyInteger('degree_id')->default(1);
			$table->tinyInteger('academic_id')->default(1);
			$table->string('username');
			$table->string('password', 60);
			$table->string('last_name', 40)->nullable();
			$table->string('first_name', 40)->nullable();
			$table->string('middle_name', 40)->nullable();
			$table->boolean('sex')->nullable();
			$table->string('year', 40)->nullable();
			$table->string('email')->unique();
			$table->string('phone')->nullable();
			$table->string('address')->nullable();
			$table->string('nation')->nullable();
			$table->string('research_area')->nullable();
			$table->string('research')->nullable();
			$table->string('actor_no')->nullable();
			$table->rememberToken();
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
		Schema::drop('users');
	}

}
