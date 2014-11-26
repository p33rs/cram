<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('follows', function(Blueprint $table)
		{
            $table->timestamps();
            $table->integer('from')->unsigned();
            $table->integer('to')->unsigned();
            $table->foreign('from')->references('id')->on('users');
            $table->foreign('to')->references('id')->on('users');
            $table->primary(['from', 'to']);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('follows');
	}

}
