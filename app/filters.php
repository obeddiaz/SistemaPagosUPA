<?php

/*
  |--------------------------------------------------------------------------
  | Application & Route filters laravelFilters
  |--------------------------------------------------------------------------
  |
  | Below you will find the "before" and "after" events for the application
  | which may be used to do any work before or after a request into your
  | application. Here you may also register your custom route filters.
  |


 */

//App::before(function($request) {
//    //header('Access-Control-Allow-Origin: *');
//    header('Access-Control-Allow-Methods: GET,POST,OPTIONS,PUT,DELETE');
//    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");
//    header('Access-Control-Allow-Credentials: true');
//});
App::before(function($request) {
    if (Request::getMethod() == "OPTIONS") {
        $headers = array(
            'Access-Control-Allow-Methods' => 'POST, GET, OPTIONS, PUT, DELETE',
            'Access-Control-Allow-Headers' => 'Origin, X-Requested-With, Content-Type, Accept, Authorization, X-Auth-Token',);
        return Response::make('', 200, $headers);
    }
});


App::after(function($request, $response) {
    //
});

/*
  |--------------------------------------------------------------------------
  | Authentication Filters
  |--------------------------------------------------------------------------
  |
  | The following filters are used to verify that the user of the current
  | session is logged into this application. The "basic" filter easily
  | integrates HTTP Basic authentication for quick, simple checking.
  |
 */

Route::filter('auth', function($route = null) {
    $aHeaders = getallheaders();
    if (!(isset($aHeaders['Origin'])&&$aHeaders['Origin'] == 'http://laravel.localhost')) {
        if (!Session::has('user')) {
            return json_encode(array('error' => true, 'message' => 'The user is not logged in'));
        } else {
            if (!isset($aHeaders['Authorization'])) {
                return json_encode(array('error' => true, 'message' => 'The user is not logged in'));
            }
            if (isset($aHeaders['Authorization'])) {
                if (Session::get('_token') != $aHeaders['Authorization']) {
                    return json_encode(array('error' => true, 'message' => 'Wrong Token'));
                }
            }
        }
    }
});

Route::filter('auth.basic', function() {
    return Auth::basic();
});

/*
  |--------------------------------------------------------------------------
  | Guest Filter
  |--------------------------------------------------------------------------
  |
  | The "guest" filter is the counterpart of the authentication filters as
  | it simply checks that the current user is not logged in. A redirect
  | response will be issued if they are, which you may freely change.
  |
 */

Route::filter('guest', function() {
    if (Auth::check())
        return Redirect::to('/');
});


/*
  |--------------------------------------------------------------------------
  | CSRF Protection Filter
  |--------------------------------------------------------------------------
  |
  | The CSRF filter is responsible for protecting your application against
  | cross-site request forgery attacks. If this special token in a user
  | session does not match the one given in this request, we'll bail.
  |
 */
Route::filter('csrf', function() {
    if (Session::token() != Input::get('_token')) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});
