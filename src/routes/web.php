<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/datapoint/create', [
    'as'    => 'datapoints.store',
    'uses'  => 'DatapointController@store'
]);

Route::get('/', [
    'as'    => 'files.index',
    'uses'  => 'FileController@index'
]);
