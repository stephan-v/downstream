<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Deploy code.
Route::post('/deploy', 'DeploymentController@deploy')->name('deploy');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::resource('/projects', 'ProjectController');

// Single deployment view.
Route::get('/projects/{projectId}/deployments/{deployment}', 'DeploymentController@show');

// Test server connection.
Route::post('/servers/connection/{serverId}', 'ServerController@connection');
// Server routes.
Route::resource('/servers', 'ServerController');

Route::resource('/projects/{project}/pipeline/servers', 'ActionServerController')->only(['store', 'destroy']);

// Custom action.
Route::resource('/projects/{project}/pipeline/actions', 'ActionController')->only(['store', 'update', 'destroy']);

// Pipeline.
Route::get('/projects/{project}/pipeline', 'PipelineController@show');
Route::patch('/projects/{project}/pipeline', 'PipelineController@update');
Route::resource('/projects/{project}/pipeline', 'PipelineController')->only(['store']);

Route::delete('/projects/{project}/pipeline/{action}', 'PipelineController@destroy');
