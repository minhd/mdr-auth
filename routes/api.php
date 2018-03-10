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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'API\Repository'], function () {
    Route::get('repository', 'RepositoryController@index');
    Route::group(['prefix' => 'repository'], function () {

        Route::apiResource('datasources', 'DataSourceController')->middleware('auth:api');

        Route::apiResource('records', 'RecordController')->middleware('auth:api');
        Route::get('records', 'RecordController@index')->name('records.index');
        Route::get('records/{record}', 'RecordController@show')->name('records.show');

        Route::apiResource('records.recordsversions', 'RecordVersionController');

        Route::model('datasource', MinhD\Repository\Datasource::class);

        Route::model('recordversion', \MinhD\Repository\RecordVersion::class);
    });
});