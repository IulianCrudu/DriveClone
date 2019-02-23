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

Route::get('/','IndexController@index');
Route::post('/','IndexController@storeRoot');
Route::post('/createFolder','IndexController@createDir');
Route::post('/{directory}','IndexController@store');
Route::get('get/{id}','IndexController@download');
Route::delete('/delete','IndexController@delete');
Route::get('/{dir}','IndexController@changeDir');
//Route::get('/{dir}','IndexController@index');
Route::delete('/{dir}','IndexController@deleteDir');