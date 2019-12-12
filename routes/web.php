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
Route::get('/demo', 'IndexController@demo');
Route::post('/chatLog/upload', 'ChatLogController@upload');
Route::get('/chatLog/get/{uid}', 'ChatLogController@get');
Route::get('/chatLog/haveRead/{wo_id}', 'ChatLogController@haveRead');
Route::get('/server/join/{uid}/{client_id}', 'ServerController@join');
Route::post('/server/send/{client_id}', 'ServerController@send');
Route::post('/server/send_by_kf/{client_id}', 'ServerController@send_by_kf');
Route::get('/dialog/index', 'DialogController@index');
Route::get('/dialog/details/{id}', 'DialogController@details');
Route::get('/dialog/getByUid/{id}', 'DialogController@getByUid');
Route::post('/dialog/create', 'DialogController@create');
Route::get('/dialog/myself', 'DialogController@myself');
Route::get('/dialog/get/{type}', 'DialogController@get');
Route::get('/dialog/completed/{id}', 'DialogController@completed');


Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Admin'], function () {
//Route::group(['middleware' => ['web'], 'namespace' => 'Admin'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/chat', 'HomeController@chat');
    Route::get('/home/test', 'HomeController@test');
    Route::get('/chatRecord/get/{wo_id}', 'ChatRecordController@get');
    Route::get('/chatRecord/haveRead/{wo_id}', 'ChatRecordController@haveRead');
    Route::get('/fastReply/get', 'FastReplyController@get');
    Route::post('/fastReply/create', 'FastReplyController@create');
    Route::get('/fastReply/delete/{id}', 'FastReplyController@delete');
    Route::get('/user/index', 'UserController@index');
    Route::post('/user/store', 'UserController@store');
    Route::post('/user/update/{id}', 'UserController@update');
    Route::get('/user/delete/{id}', 'UserController@delete');
    Route::get('/eventLog/event_log_base', 'EventLogController@event_log_base');
    Route::get('/eventLog/event_log', 'EventLogController@event_log');
});


