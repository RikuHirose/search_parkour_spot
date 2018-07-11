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

Route::post('/searchSpot','ContentController@searchSpot');

Route::post('/content/{content}/likes', 'LikesController@store');
Route::post('/likes/delete', 'LikesController@delete');

Route::post('/UserSearchMap','UserController@UserSearchMap');



// Route::post('/SearchResultMap','ContentController@SearchResultMap');

// Route::post('/postlatlng','ContentController@top');
// Route::post('/current','ContentController@top');

// Route::post('/getCurrent','ContentController@show');


