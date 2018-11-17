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

/**
 * The Github API webhook endpoint.
 *
 * Within the Github dashboard this is referred to as  the "payload URL".
 * This can be found under the repository in settings > webhooks.
 */
Route::post('/webhook', 'WebhookController@webhook');
