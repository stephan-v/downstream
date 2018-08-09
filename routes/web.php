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

// Check SSH connection.
Route::post('/connection/{serverId}', 'DeploymentController@connection');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::resource('/projects', 'ProjectsController');

// Single deployment view.
Route::get('/projects/{projectId}/deployments/{deploymentId}', 'DeploymentController@show');

Route::post('/servers', 'ServerController@store');
