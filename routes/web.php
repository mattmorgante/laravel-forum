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



Route::resource('threads', 'ThreadsController');


// replaces...
Route::get('/', 'ThreadsController@index');
Route::get('/threads', 'ThreadsController@index');
Route::get('/threads/create', 'ThreadsController@create');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show');
Route::post('/threads', 'ThreadsController@store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store');

