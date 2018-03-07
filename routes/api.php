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

        Route::resource('schemas', 'SchemaController', ['except' => ['edit', 'create']])
            ->middleware(['auth:api', 'role:admin']);

        Route::group([
            'except' => ['edit', 'create'],
            'middleware' => ['auth:api', 'role:admin']
        ], function () {
            Route::bind('version', function ($value) {
                return \MinhD\Repository\SchemaVersion::find($value) ?? abort(404);
            });
            Route::resource('schemas.versions', 'SchemaVersionController');
        });

    });
});