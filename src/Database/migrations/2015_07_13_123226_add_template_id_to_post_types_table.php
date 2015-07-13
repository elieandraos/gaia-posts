<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTemplateIdToPostTypesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('post_types', function(Blueprint $table)
		{
			$table->integer('template_id')->unsigned()->default(1);
			$table->foreign('template_id')
						->references('id')
						->on('template')
						->onDelete('cascade');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('post_types', function(Blueprint $table)
		{
			$table->dropColumn('template_id');
		});
	}

}
