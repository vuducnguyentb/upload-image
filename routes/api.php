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

Route::resource('banners','BannerController');
Route::resource('products','ProductController');
Route::post('banners/upload','BannerController@upload');

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
