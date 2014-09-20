<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AppPupulateUsersPermissions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		DB::table('up_user_permissions')->insert(array(
				'id' => '1',
                'tipo_usuario' => 'alumno'));
		DB::table('up_user_permissions')->insert(array(
				'id' => '2',
                'tipo_usuario' => 'profesor'));
		DB::table('up_user_permissions')->insert(array(
				'id' => '3',
                'tipo_usuario' => 'cajas'));
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
	}

}
