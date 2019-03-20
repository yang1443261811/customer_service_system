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
Route::get('/chatLog/clientHaveRead/{uid}', 'ChatLogController@clientHaveRead');
Route::get('/chatLog/serverHaveRead/{wo_id}', 'ChatLogController@serverHaveRead');
Route::get('/chatLog/getByClient/{uid}', 'ChatLogController@getByClient');
Route::get('/chatLog/getByServer/{wo_id}', 'ChatLogController@getByServer');
Route::post('/server/joinGroup/{client_id}', 'ServerController@joinGroup');
Route::post('/server/send/{client_id}', 'ServerController@send');
Route::post('/server/send_by_kf/{client_id}', 'ServerController@send_by_kf');
Route::get('/workOrder/getByUid/{id}', 'WorkOrderController@getByUid');
Route::post('/workOrder/create', 'WorkOrderController@create');
Route::get('/workOrder/myself', 'WorkOrderController@myself');
Route::get('/workOrder/getNew', 'WorkOrderController@getNew');


Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Admin'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/home/chat', 'HomeController@chat');
    Route::get('/home/test', 'HomeController@test');
    Route::get('/customer/lists', 'CustomerController@lists');

});


