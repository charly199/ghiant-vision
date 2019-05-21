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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/profile', 'HomeController@index')->name('profile');
Route::get('/dashboard', 'HomeController@index')->name('dasboard');
Route::get('/users', 'HomeController@index')->name('users');

Route::get('/test', 'API\UserController@profile');
