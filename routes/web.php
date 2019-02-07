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

// Authentication routes.
Route::get('login/github', 'Auth\LoginController@redirectToProvider')->name('github');
Route::get('auth/github/callback', 'Auth\LoginController@handleProviderCallback');
Route::post('logout', 'Auth\LoginController@logout');

Route::get('/', 'HomeController@index')->name('home');

Route::apiResource('projects', 'ProjectController');

// SPA routes for Vue.
Route::get('projects/{project}/servers', 'ProjectController@show');
Route::get('projects/{project}/pipeline', 'ProjectController@show')->name('pipeline');

// Single deployment view.
Route::get('projects/{project}/deployments/{deployment}', 'DeploymentController@show');

// Test server connection.
Route::post('servers/connection/{server}', 'ServerController@connection');
// Server routes.
Route::resource('servers', 'ServerController');

Route::resource('projects/{project}/pipeline/servers', 'ActionServerController')->only(['store', 'destroy']);

// Custom action.
Route::resource('projects/{project}/pipeline/actions', 'ActionController')->only(['store', 'update', 'destroy']);

// Pipeline.
Route::patch('projects/{project}/pipeline', 'PipelineController@update');
Route::resource('projects/{project}/pipeline', 'PipelineController')->only(['store']);

Route::delete('projects/{project}/pipeline/{action}', 'PipelineController@destroy');

Route::group(['middleware' => ['vcs']], function () {
    Route::post('deploy/{project}', 'DeploymentController@deploy')->name('deploy');
    Route::resource('projects.webhooks', 'ProjectWebhookController');
});
