<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/threads/create', 'ThreadsController@create')->name('thread.create');
Route::get('/threads/{channel?}', 'ThreadsController@index');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');
Route::post('/threads', 'ThreadsController@store')->name('thread.store');
Route::delete('/threads/{thread}', 'ThreadsController@destroy')->name('thread.destroy');

Route::post('/replies/{reply}/favorite','FavoritesController@store')->name('reply.favorite');

Route::get('profiles/{user}','ProfileController@show')->name('user.profile');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
