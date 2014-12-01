<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLikesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('likes', function(Blueprint $table)
		{
            $table->timestamps();
            $table->integer('photo')->unsigned();
            $table->integer('user')->unsigned();
            $table->foreign('photo')->references('id')->on('photos')->onDelete('cascade');
            $table->foreign('user')->references('id')->on('users')->onDelete('cascade');
            $table->primary(['photo', 'user']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('likes');
	}

}
