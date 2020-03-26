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

Route::post('register', 'LoginController@register');
Route::post('login', 'LoginController@login');

Route::middleware(['jwt.verify'])->group(function(){
    Route::get('detail', "DetailController@index"); //read detail
	Route::get('detail/{id}', "DetailController@getAll"); //read detail
	Route::get('detail/{id}', "DetailController@getAll"); //read detail
	Route::post('detail', 'DetailController@store'); //create detail
	Route::put('detail/{id}', "DetailController@update"); //update detail
	Route::delete('detail/{id}', "DetailController@delete"); //delete detail

});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
