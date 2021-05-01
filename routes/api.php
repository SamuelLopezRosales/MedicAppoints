<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::group([
    'prefix' => 'auth'
], function () {


    Route::group([
      'middleware' => 'auth:api'
    ], function() {
        Route::get('user', 'AuthController@user');
    });
});

Route::get('prueba', 'AuthController@prueba');
Route::post('signup', 'AuthController@signUp');
Route::post('login', 'AuthController@login');


// devuelve la lista de especialidades
Route::get('/specialties','SpeicaltyController@index');
// devuleve los medicos segun la especialidad
Route::get('/specialties/{specialty}/doctors','SpeicaltyController@doctors');
// devuleve las horas segun el medico y el dia
Route::get('/schedule/hours','ScheduleController@hours');




Route::middleware('auth:api')->group(function() {
    Route::get('/user', 'UserController@show');
    Route::post('logout', 'AuthController@logout');

    // APPOINTMENTS
    Route::post('/appointments','AppointmentController@store');
    Route::get('/appointments','AppointmentController@index');
});

