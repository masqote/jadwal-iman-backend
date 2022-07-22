<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DateController;
use App\Http\Controllers\JadwalController;
use App\Http\Controllers\Auth\LoginController;

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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/user', function(Request $request) {
        return auth()->user();
    });
    Route::post('/logout', [LoginController::class, 'logout']);
});

Route::post('/login', [LoginController::class, 'login']);

// ============= GLOBAL =====================
Route::get('/get-ustadz', 'App\Http\Controllers\Backend\UstadzController@index');
Route::get('/get-province', 'App\Http\Controllers\Backend\ProvinceController@index');
Route::get('/get-city', 'App\Http\Controllers\Backend\CityController@index');


// ============= Frontend =====================

Route::get('/date-single', [DateController::class, 'index']);
Route::get('/get-jadwal', [JadwalController::class, 'index']);
Route::get('/get-jadwal/{slug}', [JadwalController::class, 'slug']);


// ============= Backend =====================

Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/check_token', [LoginController::class, 'check_token']);
    Route::get('/jadwal/index', 'App\Http\Controllers\Backend\JadwalController@index');
    Route::post('/jadwal/add', 'App\Http\Controllers\Backend\JadwalController@addData');
    Route::post('/jadwal/delete', 'App\Http\Controllers\Backend\JadwalController@deleteData');
});
// Route::get('/jadwal/index', 'App\Http\Controllers\Backend\JadwalController@index');
