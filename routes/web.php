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
    return redirect('home');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users', 'Auth\UsersController@index')->name('users');
Route::get('/user/edit/{id}', 'Auth\UsersController@edit')->name('editUser');
Route::post('/user/update/{id}', 'Auth\UsersController@update')->name('updateUser');
Route::get('/password/edit/{id}', 'Auth\UsersController@editPassword')->name('editPassword');
Route::post('/password/update/{id}', 'Auth\UsersController@updatePassword')->name('updatePassword');
Route::get('/user/delete/{id}', 'Auth\UsersController@deleteUser')->name('deleteUser');
Route::get('/registry/new', 'HomeController@create')->name('newRegistry');

Route::get('/registry/edit/{id}', 'HomeController@edit')->name('editRegistry');
Route::post('/registry/save', 'HomeController@save')->name('saveRegistry');
Route::post('/registry/update/{id}', 'HomeController@update')->name('updateRegistry');
Route::get('/registry/delete/{id}', 'HomeController@delete')->name('deleteRegistry');
Route::post('/period/save', 'HomeController@savePeriod')->name('savePeriod');
Route::post('/period/edit', 'HomeController@editPeriod')->name('editPeriod');
Route::get('/period/delete', 'HomeController@deletePeriod')->name('deletePeriod');
Route::get('/period/export', 'HomeController@export')->name('exportRegistry');
Route::get('/word', 'HomeController@word')->name('wordRegistry');
