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
	return 'user no logged';
});
Route::group(array('prefix' => '/api/{token}','before' => 'auth'), function()
{
	//resource conceptos 
	Route::group(array('prefix' => '/conceptos'), function(){
		Route::get('/', array('uses' => 'ConceptosController@index'));
		Route::get('/create', array('uses' => 'conceptossController@create'));
		Route::post('/', array('uses' => 'ConceptosController@store'));
		Route::get('/{id}', array('uses' => 'ConceptosController@show'));
		Route::get('/{id}/edit', array('uses' => 'ConceptosController@edit'));
		Route::put('/{id}', 'ConceptosController@update');
		Route::delete('/{id}', 'ConceptosController@destroy');
		Route::post('/create', array('uses' => 'conceptosController@post_create'));
	});
	//resource subconcepto 
	Route::group(array('prefix' => '/sub_conceptos'), function(){
		Route::get('/', array('uses' => 'SubConceptosController@index'));
		Route::post('/create/{id_concepto}', array('uses' => 'SubConceptosController@create'));
	});
	//resource Personas
	Route::group(array('prefix' => '/personas'), function(){
		Route::get('/', array('as' => 'personas', 'uses' => 'PersonasController@index'));
		Route::get('{id}', array('as' => 'persona_by_id', 'uses' => 'PersonasController@show'));
		Route::get('/admin', array('as' => 'personas_admin_all', 'uses' => 'PersonasController@show_admin'));
		Route::get('/admin/{id}', array('as' => 'personas_admin', 'uses' => 'PersonasController@show_admin_by_id'));
		Route::get('/alumno', array('as' => 'personas_alumno_all', 'uses' => 'PersonasController@show_alumno'));
		Route::get('/alumno/{id}', array('as' => 'personas_alumno', 'uses' => 'PersonasController@show_alumno_by_id'));
	});
});

Route::get('user/{nocuenta}/{password}', array('as' => 'user', 'uses' => 'usuariosController@show'));