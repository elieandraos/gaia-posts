<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTranslationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('post_translations', function(Blueprint $table)
		{
			$table->increments('id');

			//Translatable attributes
			$table->string('title');
			$table->text('excerpt');
			$table->text('description');
			$table->string('slug');
		    // Translatable attributes

		    $table->integer('post_id')->unsigned()->index();
		    $table->foreign('post_id')->references('id')->on('post')->onDelete('cascade');

		    $table->integer('locale_id')->unsigned()->index();
		    $table->foreign('locale_id')->references('id')->on('locales')->onDelete('cascade');
		    
		    $table->unique(['post_id', 'locale_id']);

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
		Schema::drop('post_translations');
	}

}
