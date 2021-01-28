<?php

// --------------------------
// Custom Backpack Routes
// --------------------------
// This route file is loaded automatically by Backpack\Base.
// Routes you generate using Backpack\Generators will be placed here.






Route::post('api/topics', 'App\Http\Controllers\Api\TopicsApiController@index');
Route::post('api/addcolumn', 'App\Http\Controllers\Admin\ClientCrudController@add');
Route::post('api/removecolumn', 'App\Http\Controllers\Admin\ClientCrudController@remove');

Route::group([
    'prefix'     => config('backpack.base.route_prefix', 'admin'),
    'middleware' => ['web', config('backpack.base.middleware_key', 'admin')],
    'namespace'  => 'App\Http\Controllers\Admin',
], function () { // custom admin routes
    // CRUD resources and other admin routes


    Route::crud('device', 'DeviceCrudController');
    Route::crud('topic', 'TopicCrudController');
    Route::get('device/{id}/clients', 'ClientCrudController@showClientsForDevice');

    Route::crud('topic', 'TopicCrudController');
    Route::crud('client', 'ClientCrudController');
    Route::get('client/{id}/metrics', 'ClientCrudController@metrics');

    Route::crud('metric', 'MetricCrudController');

    Route::get('/', function () {
        return redirect('admin/dashboard');
    });

    Route::get('', function () {
        return redirect('admin/dashboard');
    });
    Route::crud('widget', 'WidgetCrudController');
    Route::crud('alert', 'AlertCrudController');
}); // this should be the absolute last line of this file
