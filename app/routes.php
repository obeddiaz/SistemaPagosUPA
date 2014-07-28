<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});


// conceptos resource
Route::get('conceptos', array('as' => 'conceptos', 'uses' => 'conceptosController@index'));
Route::get('conceptos/create', array('as' => 'concept', 'uses' => 'conceptosController@create'));
Route::post('conceptos', array('as' => 'new_concept', 'uses' => 'conceptosController@store'));
Route::get('conceptos/{id}', array('as' => 'concept', 'uses' => 'conceptosController@show'));
Route::get('conceptos/{id}/edit', array('as' => 'concept', 'uses' => 'conceptosController@edit'));
Route::put('conceptos/{id}', 'conceptosController@update');
Route::delete('conceptos/{id}', 'conceptosController@destroy');
Route::post('conceptos/create', array('as' => 'new_concept', 'uses' => 'conceptosController@post_create'));


//usuarios resource
//Route::get('user', array('as' => 'conceptos', 'uses' => 'conceptosController@index'));
//Route::get('user/create', array('as' => 'concept', 'uses' => 'conceptosController@create'));
//Route::post('user', array('as' => 'new_concept', 'uses' => 'conceptosController@store'));
Route::get('user/{nocuenta}/{password}', array('as' => 'user', 'uses' => 'usuariosController@show'));
//Route::get('conceptos/{id}/edit', array('as' => 'concept', 'uses' => 'conceptosController@edit'));
//Route::put('conceptos/{id}', 'conceptosController@update');
//Route::delete('conceptos/{id}', 'conceptosController@destroy');
//Route::post('conceptos/create', array('as' => 'new_concept', 'uses' => 'conceptosController@post_create'));

Route::get('test', function(){
   //$user = Usuarios::where('nocuenta', 'UP100682')->first();
   //return $user->idcurso;
	$user=Usuarios::where('nocuenta', 'UP100682')
	->join('persona', 'alumno.idpersonas', '=', 'persona.idpersonas')
    ->select('persona.nombre')
    ->first();
    return $user;
});