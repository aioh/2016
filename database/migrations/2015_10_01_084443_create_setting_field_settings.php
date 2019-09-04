<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSettingFieldSettings extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('field_settings', function(Blueprint $table)
		{
			$table->integer('template_id')->unsigned();
			$table->string('label');
			$table->string('var');
			$table->text('type');
			$table->text('tab');
			$table->integer('sequence');		
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('field_settings');
	}

}
