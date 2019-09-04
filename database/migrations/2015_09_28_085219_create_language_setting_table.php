<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageSettingTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('setting_translations', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('locale')->index();
			$table->integer('setting_id')->unsigned();

			$table->text('value');	
			$table->unique(['setting_id','locale']);
		    $table->foreign('setting_id')->references('id')->on('settings')->onDelete('cascade');				
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('setting_translation');
	}

}
