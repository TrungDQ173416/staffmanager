<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
	
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function (Blueprint $table) {
			$table->increments('id');
			$table->string('username')->unique();
			// $table->string('gender');
            // $table->date('birthday');
            // $table->date('phone');
            // $table->string('address');
            // $table->integer('role_id')->unsigned();
            // $table->foreign('role_id')->references('id')->on('roles');
			$table->string('name')->nullable();
			$table->string('email')->nullable()->unique();
			$table->string('password');
			$table->rememberToken();
			$table->timestamps();
			$table->softDeletes();
		});
	}
	
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('users');
	}
	
}
