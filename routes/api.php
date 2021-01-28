<?php

use Illuminate\Http\Request;

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



Route::post('api/topics', 'Api\TopicsApiController@index');


Route::get('charts', 'Api\ChartsApiController@index');
Route::get('latest', 'Api\ChartsApiController@latest');
Route::get('latestWithTime', 'Api\ChartsApiController@latestWithTime');
Route::get('latest20', 'Api\ChartsApiController@latest20');
Route::get('percentage', 'Api\ChartsApiController@percentage');
Route::get('pyramid', 'Api\ChartsApiController@pyramid');


