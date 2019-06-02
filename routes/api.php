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
// Front end apis
Route::apiResources(['about' => 'API\AboutsController']);
Route::apiResources(['contact' => 'API\ContactsController']);
Route::apiResources(['owner' => 'API\OwnersController']);
Route::apiResources(['product' => 'API\ProductsController']);
Route::apiResources(['representation' => 'API\RepresentationsController']);
Route::apiResources(['reps_det' => 'API\RepresentationDetsController']);

// Backend apis
Route::apiResources(['user' => 'API\UserController']);
Route::apiResources(['city' => 'API\CitiesController']);
Route::apiResources(['country' => 'API\CountriesController']);

Route::get('profile', 'API\UserController@profile');
Route::put('profile', 'API\UserController@updateProfile');

Route::get('countries', 'API\CountriesController@selectAll');

Route::get('findUser', 'API\UserController@search');
