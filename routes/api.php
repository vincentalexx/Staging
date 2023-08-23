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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
    Route::prefix('congregation-attendances')->name('congregation-attendances/')->group(static function() {
        Route::post('/congregation-attendance/create',              'CongregationAttendancesController@createCongregationAttendance');
    });
});