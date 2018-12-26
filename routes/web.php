<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('auth/facebook', 'Auth\FacebookController@redirectToFacebook');
Route::get('auth/facebook/callback', 'Auth\FacebookController@handleFacebookCallback');


Route::get('/test', 'TestController@index');
Route::post('/test', 'TestController@prepare');
Route::post('/test/{test_id}/next/{id}', 'TestController@next');
Route::get('/test/{test_id}/judge', 'TestController@judge');
Route::get('/test/{test_id}/details', 'TestController@detail');
Route::get('/test/{test_id}/alldetails', 'TestController@allDetail');
Route::get('/test/{test_id}/{id}', 'TestController@show');

Route::get('/history','HistoryController@index');
// Route::get('/history_api','HistoryController@history_api');

Route::get('/textbook','TextbookController@index');
Route::get('/textbooklink/{hashlink}','TextbookController@textbooklink');

Route::get('/privacy', function () {
    return view('privacy');
});

Route::get('/logout', 'Auth\LoginController@logout');


