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

Route::get('/', function() {
    return view('welcome');
});

// Deploy code.
Route::post('/deploy', 'DeploymentController@deploy');
// Check SSH connection.
Route::post('/connection', 'DeploymentController@connection');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('/projects', 'ProjectsController');
