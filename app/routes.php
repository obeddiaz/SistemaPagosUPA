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

header('Access-Control-Allow-Origin: http://laravel.localhost');
Route::get('/', function() {
    return 'user no logged';
});
Route::group(array('prefix' => '/api', 'before' => 'auth'), function() {

    //resource conceptos 
    Route::group(array('prefix' => '/conceptos'), function() {
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
    Route::group(array('prefix' => '/sub_conceptos'), function() {
        Route::get('/', array('uses' => 'SubConceptosController@index'));
        Route::post('/create/{id_concepto}', array('uses' => 'SubConceptosController@create'));
    });

    //resource Personas
    Route::group(array('prefix' => '/personas'), function() {
        Route::get('/', array('as' => 'personas', 'uses' => 'PersonasController@index'));
        Route::get('/alumno/nombre/', array('as' => 'personas_alumno_nombre', 'uses' => 'PersonasController@show_alumno_by_nombre'));
        Route::get('/admin/{id?}', array('as' => 'personas_admin', 'uses' => 'PersonasController@show_admin'));
        Route::get('/alumno/{id?}', array('as' => 'personas_alumno', 'uses' => 'PersonasController@show_alumno'));
        Route::get('/profesor/{id?}', array('as' => 'personas_alumno', 'uses' => 'PersonasController@show_profesor'));
        Route::get('/{id}', array('as' => 'persona_by_id', 'uses' => 'PersonasController@show'));
        Route::get('/alumno/matricula/{nocuenta}', array('as' => 'personas_alumno_matricula', 'uses' => 'PersonasController@show_alumno_by_nocuenta'));
    });

    Route::group(array('prefix' => '/nivel_academico'), function() {
        Route::get('/', array('as' => 'nivel_academico', 'uses' => 'NivelesController@index'));
        Route::get('/show_by_id/{id}', array('as' => 'nivel_academico', 'uses' => 'NivelesController@show'));
        Route::get('/show_by_matricula/{nocuenta}', array('as' => 'nivel_academico_alumno', 'uses' => 'NivelesController@show_by_nocuenta'));
    });

    Route::group(array('prefix' => '/becas'), function() {
        Route::get('/', array('as' => 'becas', 'uses' => 'BecasController@index'));
        Route::get('/show/', array('as' => 'becas', 'uses' => 'BecasController@show'));
        Route::get('/show_by_matricula/', array('as' => 'becas_alumno', 'uses' => 'BecasController@show_by_nocuenta'));
    });

    Route::group(array('prefix' => '/grados'), function() {
        Route::get('/', array('as' => 'grados', 'uses' => 'GradosController@index'));
        Route::get('/show_cuatrimestres_cursados/{nocuenta}', array('as' => 'grados', 'uses' => 'GradosController@show_by_nocuenta'));
        Route::get('/show_grado/{nocuenta}', array('as' => 'grados_alumno', 'uses' => 'GradosController@show_grado_by_nocuenta'));
    });

    Route::group(array('prefix' => '/cobros'), function() {
        Route::get('/show_info', array('as' => 'cobros', 'uses' => 'CobrosController@show_info_alumno_estado_de_cuenta'));
        Route::get('/', array('as' => 'cobros', 'uses' => 'CobrosController@index'));
        Route::get('/show/{id}', array('as' => 'cobros', 'uses' => 'CobrosController@show'));
        Route::get('/show_estado_de_cuenta', array('as' => 'estado_de_cuenta_alumno', 'uses' => 'CobrosController@show_estado_de_cuenta'));
        Route::post('/create', array('as' => 'cobros', 'uses' => 'CobrosController@create_alumno'));
    });
    Route::group(array('prefix' => '/ciclos'), function() {
        Route::get('/', array('as' => 'cobros', 'uses' => 'CiclosController@index'));
        Route::get('/show/{id}', array('as' => 'cobros', 'uses' => 'CiclosController@show'));
        Route::get('/show', array('as' => 'estado_de_cuenta_alumno', 'uses' => 'CiclosController@show_by_nocuenta'));
    });
});

Route::group(array('prefix' => '/user'), function() {
    Route::get('/login', array('as' => 'user', 'uses' => 'usuariosController@login'));
    Route::get('/show', array('as' => 'user', 'uses' => 'usuariosController@show'));
});

//App::missing(function($exception)
//{
//    //ar_dump($exception);
//    //return Response::view('errors.missing', array(), 404);
//    Log::error($exception);
////
//    $message = $exception->getMessage();
//    var_dump($message);
////
////    // switch statements provided in case you need to add
////    // additional logic for specific error code.
////    switch ($code) {
////        case 401:
////            return Response::json(array(
////                    'code'      =>  401,
////                    'message'   =>  $message
////                ), 401);
////        case 404:
////            $message            = (!$message ? $message = 'the requested resource was not found' : $message);
////            return Response::json(array(
////                    'code'      =>  404,
////                    'message'   =>  $message
////                ), 404);        
////    }
//});

App::missing(function($e) {
    return json_encode(array('error'=>true,'message'=>'There are something Wrong. Error 404','response'=>''));
});