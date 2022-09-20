<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DateController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Master\EventController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'api','prefix' => 'auth'], function ($router) {
    Route::post('login', [LoginController::class, 'login']);
    Route::post('logout', [LoginController::class, 'logout']);
    Route::post('refresh', [LoginController::class, 'refresh']);
    Route::post('me', [LoginController::class, 'me']);
});



Route::post('/login', [LoginController::class, 'login']);

// ============= GLOBAL =====================
Route::get('/get-ustadz', 'App\Http\Controllers\Backend\UstadzController@index');
Route::get('/get-ustadz-detail', 'App\Http\Controllers\Backend\UstadzController@show');
Route::get('/get-province', 'App\Http\Controllers\Backend\ProvinceController@index');
Route::get('/get-city', 'App\Http\Controllers\Backend\CityController@index');


// ============= Frontend =====================
Route::get('/get-ustadz-favorit', 'App\Http\Controllers\Backend\UstadzController@ustadzFavorit');
Route::get('/date-single', [DateController::class, 'index']);
Route::get('/get-jadwal', [JadwalController::class, 'index']);
Route::get('/get-jadwal-ustadz', [JadwalController::class, 'jadwalUstadz']);
Route::get('/get-jadwal/{slug}', [JadwalController::class, 'slug']);
Route::get('/get-event', 'App\Http\Controllers\EventController@index');
Route::get('/get-event-detail', 'App\Http\Controllers\EventController@show');


// ============= Backend =====================

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/check_token', [LoginController::class, 'check_token']);
    Route::get('/jadwal/index', 'App\Http\Controllers\Backend\JadwalController@index');
    Route::post('/jadwal/add', 'App\Http\Controllers\Backend\JadwalController@addData');
    Route::post('/jadwal/delete', 'App\Http\Controllers\Backend\JadwalController@deleteData');
});
// Route::get('/jadwal/index', 'App\Http\Controllers\Backend\JadwalController@index');
