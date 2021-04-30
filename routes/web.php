<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    //return view('welcome');
    return redirect('/login');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth','admin'])->namespace('Admin')->group(function(){
	Route::get('/specialties','SpecialtyController@index');
	Route::get('/specialties/create','SpecialtyController@create');
	Route::get('/specialties/{specialty}/edit','SpecialtyController@edit');

	Route::post('/specialties', 'SpecialtyController@store');
	Route::put('/specialties/{specialty}','SpecialtyController@update');
	Route::delete('/specialties/{specialty}','SpecialtyController@destroy');


	// DOCTROS
	Route::resource('doctors','DoctorController');
	Route::resource('patients','PatientController');

	Route::get('/charts/appointments/line','ChartController@appointments');
	Route::get('/charts/doctors/bar','ChartController@doctors');
});


Route::middleware(['auth','doctor'])->namespace('Doctor')->group(function(){
	Route::get('/schedule','ScheduleController@edit');
	Route::post('/schedule','ScheduleController@store');
});

Route::middleware('auth')->group(function(){
	Route::get('/appointments/create','AppointmentController@create');
	Route::post('/appointments','AppointmentController@store');

	Route::get('/appointments','AppointmentController@index');
	Route::get('/appointments/{appointment}','AppointmentController@show');
	Route::get('/appointments/{appointment}/cancel','AppointmentController@showCancelForm'); // formulario de cancelacion
	Route::post('/appointments/{appointment}/cancel','AppointmentController@postCancel');
// acceder a la informacion de los medicos asociados a dicha especialidad json

	Route::post('/appointments/{appointment}/confirm','AppointmentController@postConfirm');

});

