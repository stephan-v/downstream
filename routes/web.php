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
Route::get('/projects/{projectId}/deployments/{deploymentId}', 'DeploymentController@show');

// Test server connection.
Route::post('/servers/connection/{serverId}', 'ServerController@connection');
// Server routes.
Route::resource('/servers', 'ServerController');
