<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagePostTable extends Migration {

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
			$table->integer('post_id')->unsigned();
			$table->string('locale')->index();

			$table->string('title');			
			$table->text('content');
			$table->text('option');
			$table->text('images');
			$table->text('old_images');
			$table->string('menu_title');
			$table->string('seo_title');
			$table->text('meta');

			$table->unique(['post_id','locale']);
		    $table->foreign('post_id')->references('id')->on('posts')->onDelete('cascade');			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('post_translation');
	}

}
