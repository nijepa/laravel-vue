<?php

use Illuminate\Http\Request;
use App\User;
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
Route::apiResources(['owner' => 'API\OwnersController']);
Route::apiResources(['representation' => 'API\RepresentationsController']);
Route::apiResources(['reps_det' => 'API\RepresentationDetsController']);
Route::apiResources(['product' => 'API\ProductsController']);
Route::apiResources(['product_dets' => 'API\ProductDetsController']);
Route::apiResources(['about_dets' => 'API\AboutDetsController']);
Route::apiResources(['news' => 'API\NewsController']);

Route::get('productF', 'API\ProductsController@productF');
Route::get('contactF', 'API\ContactsController@contactF');
Route::get('aboutF', 'API\AboutsController@aboutF');


// Backend apis
Route::apiResources(['user' => 'API\UserController']);
Route::apiResources(['city' => 'API\CitiesController']);
Route::apiResources(['country' => 'API\CountriesController']);
Route::apiResources(['product' => 'API\ProductsController']);
Route::apiResources(['newsb' => 'API\NewsController']);
Route::apiResources(['contact' => 'API\ContactsController']);
Route::apiResources(['about' => 'API\AboutsController']);
Route::apiResources(['reps' => 'API\RepresentationsController']);

Route::get('profile', 'API\UserController@profile');
Route::put('profile', 'API\UserController@updateProfile');

Route::get('countries', 'API\CountriesController@selectAll');

Route::get('findUser', 'API\UserController@search');

// Web App apis
Route::get('companies', 'API\RepresentationsController@companies');

Route::apiResources(['project' => 'API\ProjectsController']);
Route::apiResources(['project_dets' => 'API\ProjectDetsController']);

Route::apiResources(['meeting' => 'API\MeetingsController']);
Route::apiResources(['meeting_dets' => 'API\MeetingDetsController']);

Route::apiResource('roles', 'API\RoleController');
Route::apiResource('permissions', 'API\PermissionController');
Route::apiResource('activities', 'API\ActivityController');

Route::apiResource('todo', 'API\ToDoController');
Route::patch('todo/{id}', 'API\ToDoController@markCompleted');

Route::apiResource('message', 'API\MessageController');
Route::get('chatContact', 'API\UserController@chat');

Route::get('indexGrouped', 'API\ProjectsController@indexGrouped');

// Mark read all notifications
Route::get('/mark-all-read/{user}', function (User $user) {
    $user->unreadNotifications->markAsRead();
    return response(['message'=>'done', 'notifications'=>$user->notifications]);
});