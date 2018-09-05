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
Route::post('deploy', 'DeploymentController@deploy')->name('deploy');

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::resource('projects', 'ProjectController');

// Single deployment view.
Route::get('projects/{projectId}/deployments/{deploymentId}', 'DeploymentController@show');

// Test server connection.
Route::post('servers/connection/{serverId}', 'ServerController@connection');
// Server routes.
Route::resource('servers', 'ServerController');

// Actions.
Route::get('/projects/{projectId}/actions','ActionController@index');

Route::prefix('projects/{projectId}/actions')->group(function() {
    Route::post('clean', 'Actions\CleanOldReleasesController@store');
    Route::post('clone', 'Actions\CloneRepositoryController@store');
    Route::post('composer', 'Actions\ComposerController@store');
    Route::post('ssh', 'Actions\SSHController@store');
});
