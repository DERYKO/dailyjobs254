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

Route::get('/{any}', 'SpaController@index')->where('any', '.*');

Auth::routes();

Route::post('profile', 'ProfilesController@show');
Route::post('accept-bid', 'ApplicationController@update');
Route::post('wallet', 'WalletController@balance');
Route::post('notifications', 'ApplicationController@index');
Route::post('view-jobs', 'JobsController@index');
Route::post('save-job', 'JobsController@store');
Route::post('logout', 'Auth\LoginController@logout');
Route::post('applications', 'ApplicationController@store');
Route::post('job-details/get-job/{id}', 'JobsController@job');
Route::post('user/update/{id}', 'ProfilesController@update');
Route::post('profiles','ProfilesController@index');
Route::post('education','ProfilesController@education');
Route::post('experience','ProfilesController@experience');
Route::post('transcations','JobsController@transaction_logs');
Route::post('completed','JobsController@complete');
Route::post('active','JobsController@active');



