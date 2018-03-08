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

        Route::bind('datasource', function ($value) {
            return \MinhD\Repository\DataSource::find($value) ?? abort(404);
        });

        Route::resource('datasources', 'DataSourceController',
            ['except' => ['edit', 'create']])->middleware('auth:api');

        Route::resource('records', 'RecordController', ['except' => ['edit', 'create']])->middleware('auth:api');
        Route::get('records', 'RecordController@index')->name('records.index');
        Route::get('records/{record}', 'RecordController@show')->name('records.show');

        Route::resource('records.recordsversions', 'RecordVersionController', [
            'except' => ['edit', 'create']
        ]);

        Route::resource('schemas', 'SchemaController', [
            'except' => ['edit', 'create']
        ])->middleware(['auth:api', 'role:admin']);
        Route::resource('schemas.schemaversions', 'SchemaVersionController', [
            'except' => ['edit', 'create']
        ]);

        Route::model('schemaversion', \MinhD\Repository\SchemaVersion::class);
        Route::model('recordversion', \MinhD\Repository\RecordVersion::class);

    });
});