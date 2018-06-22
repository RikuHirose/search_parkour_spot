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
use App\Content;

Auth::routes();

// Route::get('/', 'HomeController@index')->name('home');
// Route::get('/upload', 'HomeController@edit');
// Route::post('/upload','HomeController@upload');

// ContentController
Route::resource('/content','ContentController', ['except' => ['store'],['index']]);

Route::get('/', function () {
    return view('welcome');
});
Route::get('/','ContentController@top');

Route::post('/content/store','ContentController@store');

Route::get('/content/{id}/route','ContentController@getroute');

Route::post('/searchSpot','ContentController@searchSpot');

Route::get('/content/id/editlist','ContentController@getEditList');


Route::get('/login/{provider}',          'Auth\SocialAccountController@redirectToProvider');
Route::get('login/{provider}/callback', 'Auth\SocialAccountController@handleProviderCallback');
