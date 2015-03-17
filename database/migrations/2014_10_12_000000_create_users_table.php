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
			$table->tinyInteger('degree_id');
			$table->tinyInteger('academic_id');
			$table->string('username');
			$table->string('password', 60);
			$table->string('last_name', 40);
			$table->string('first_name', 40);
			$table->string('middle_name', 40);
			$table->boolean('sex');
			$table->string('year', 40);
			$table->string('email')->unique();
			$table->string('phone');
			$table->string('address');
			$table->string('nation');
			$table->string('research_area');
			$table->string('research');
			$table->string('actor_no');
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
