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
Route::get('/chatLog/haveRead/{id}', 'ChatLogController@haveRead');
Route::post('/chatLog/get', 'ChatLogController@get');
Route::post('/chatLog/upload', 'ChatLogController@upload');
Route::post('/server/joinGroup/{client_id}', 'ServerController@joinGroup');
Route::post('/server/send/{client_id}', 'ServerController@send');


Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Admin'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/customer/lists', 'CustomerController@lists');
});


