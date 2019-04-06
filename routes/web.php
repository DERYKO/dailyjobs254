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

Route::post('user',function (\Illuminate\Http\Request $request){
    return \Illuminate\Support\Facades\Auth::user();
});
Route::post('view-jobs','JobsController@index');
Route::post('save-job','JobsController@store');
Route::post('logout','Auth\LoginController@logout');
Route::post('applications','ApplicationController@store');
Route::post('job-details/get-job/{id}','JobsController@job');
Route::post('user/update/{id}','ProfilesController@update');


