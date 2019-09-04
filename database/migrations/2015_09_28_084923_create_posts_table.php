<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('posts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('slug');
			$table->text('thumbnail');
			$table->text('main_images');
			$table->text('old_main_images');
			$table->integer('status');
			$table->integer('author_id')->unsigned();
			$table->integer('parent_id')->unsigned();
			$table->integer('sequence');
			$table->string('type');
			$table->integer('template_id')->unsigned();			
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
		Schema::drop('posts');
	}

}
