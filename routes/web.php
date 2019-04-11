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
Route::post('/chatLog/upload', 'ChatLogController@upload');
Route::get('/chatLog/get/{uid}', 'ChatLogController@get');
Route::get('/chatLog/haveRead/{wo_id}', 'ChatLogController@haveRead');
Route::post('/server/join/{client_id}', 'ServerController@join');
Route::post('/server/send/{client_id}', 'ServerController@send');
Route::post('/server/send_by_kf/{client_id}', 'ServerController@send_by_kf');
Route::get('/workOrder/getByUid/{id}', 'WorkOrderController@getByUid');
Route::post('/workOrder/create', 'WorkOrderController@create');
Route::get('/workOrder/myself', 'WorkOrderController@myself');
Route::get('/workOrder/get/{type}', 'WorkOrderController@get');
Route::get('/workOrder/completed/{id}', 'WorkOrderController@completed');


//Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Admin'], function () {
Route::group(['middleware' => ['web'], 'namespace' => 'Admin'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/chat', 'HomeController@chat');
    Route::get('/home/test', 'HomeController@test');
    Route::get('/chatRecord/get/{wo_id}', 'ChatRecordController@get');
    Route::get('/chatRecord/haveRead/{wo_id}', 'ChatRecordController@haveRead');
    Route::get('/fastReply/get', 'FastReplyController@get');
    Route::post('/fastReply/create', 'FastReplyController@create');
    Route::get('/fastReply/delete/{id}', 'FastReplyController@delete');
    Route::get('/user/index', 'UserController@index');
    Route::post('/user/update/{id}', 'UserController@update');

});


