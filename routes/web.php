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

Auth::routes();

Route::get('/', 'IndexController@index');
Route::get('/chatLog/{uid}/get', 'ChatLogController@get');
Route::post('/chatLog/store', 'ChatLogController@store');
Route::post('/chatLog/upload', 'ChatLogController@upload');
Route::post('/server/joinGroup', 'ServerController@joinGroup');


Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Admin'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/customer/lists', 'CustomerController@lists');
});


