<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    /**
     * Redirect user to app page if already logged in.
     */
    if(Auth::check())
        return redirect('/app');

    return view('welcome');
});

Auth::routes();

Route::get('/app', 'AppController@index');

Route::get('/dev', function () {
    /**
     * Redirect if guest.
     */
    if(! Auth::check())
        return redirect('/login');

    return view('dev');
});
