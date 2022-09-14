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
    return view('welcome');
});

Route::get('/login', 'App\Http\Controllers\AuthController@login')->name('login')->middleware('guest');
Route::post('/login', 'App\Http\Controllers\AuthController@authenticate')->middleware('guest');

Route::get('/dashboard', 'App\Http\Controllers\DashboardController@index')->middleware('auth');

Route::group(['prefix' => 'master'], function () {

    Route::get('/jadwal', 'App\Http\Controllers\Master\JadwalController@index')->name('jadwal')->middleware('auth');
    Route::get('/jadwallist', 'App\Http\Controllers\Master\JadwalController@jadwalIndex')->name('jadwal.index')->middleware('auth');

    Route::get('/jadwal/add', 'App\Http\Controllers\Master\JadwalController@add')->middleware('auth');
    Route::post('/jadwal/store', 'App\Http\Controllers\Master\JadwalController@store')->middleware('auth');

    Route::get('/jadwal/edit/{id}', 'App\Http\Controllers\Master\JadwalController@edit')->middleware('auth');
    Route::post('/jadwal/update/{id}', 'App\Http\Controllers\Master\JadwalController@update')->middleware('auth');

    Route::post('/jadwal/delete', 'App\Http\Controllers\Master\JadwalController@deleteData')->name('jadwal.delete')->middleware('auth');


    Route::get('/event', 'App\Http\Controllers\Master\EventController@index')->name('event')->middleware('auth');
    Route::get('/eventlist', 'App\Http\Controllers\Master\EventController@eventIndex')->name('event.index')->middleware('auth');

    Route::get('/event/add', 'App\Http\Controllers\Master\EventController@add')->middleware('auth');
    Route::post('/event/store', 'App\Http\Controllers\Master\EventController@store')->middleware('auth');

    Route::get('/event/edit/{id}', 'App\Http\Controllers\Master\EventController@edit')->middleware('auth');
    Route::post('/event/update/{id}', 'App\Http\Controllers\Master\EventController@update')->middleware('auth');

    Route::post('/event/delete', 'App\Http\Controllers\Master\EventController@deleteData')->name('event.delete')->middleware('auth');

   
});
