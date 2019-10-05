<?php

use Illuminate\Http\Request;
// use Helper;
// use Curl;
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
//
if (Cache::has('routing')) {
    $cache_query = Cache::get('routing');
    Route::middleware(['auth:api'])->group(function () use ($cache_query) {
        foreach ($cache_query as $route) {
            Route::post($route->action_module, $route->action_path . '@data')->name($route->action_module . '_api');
        }
    });
}

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');
