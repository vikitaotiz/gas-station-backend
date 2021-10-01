<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('/register', 'AuthController@register');
    Route::post('/login', 'AuthController@login');
    Route::post('/logout', 'AuthController@logout');
});

Route::get('/user', 'AuthController@user')->middleware('auth:api');
Route::apiResource('/roles', 'RoleController')->middleware('auth:api');

Route::apiResource('/product_categories', 'ProductCategoriesController')->middleware('auth:api');
Route::apiResource('/products', 'ProductsController')->middleware('auth:api');