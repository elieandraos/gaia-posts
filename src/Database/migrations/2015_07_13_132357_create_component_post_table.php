<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateComponentPostTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('component_post', function(Blueprint $table)
		{
			$table->increments('id');

			$table->integer('component_id')->unsigned()->index();
			$table->foreign('component_id')->references('id')->on('component')->onDelete('cascade');
			$table->integer('post_id')->unsigned()->index();
			$table->foreign('post_id')->references('id')->on('post')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('component_post');
	}

}
