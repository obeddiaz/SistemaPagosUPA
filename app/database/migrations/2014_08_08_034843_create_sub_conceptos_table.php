<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSubConceptosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('up_sub_conceptos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('sub_concepto');
			$table->integer('concepto_id')->unsigned();
			$table->timestamps();
		});
		Schema::table('up_sub_conceptos',function($table){
			$table->foreign('concepto_id')->references('id')->on('conceptos')->onDelete('cascade');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('sub_conceptos');
	}

}
