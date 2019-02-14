<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'UserController@login');
Route::post('signup', 'UserController@signup');

Route::group(['middleware'=> 'auth.jwt'], function (){
    Route::get('/forms', 'FormController@index');
    Route::delete('/forms/{form}', 'FormController@destroy');
    Route::put('/forms/{form}', 'FormController@update');
    Route::post('/forms', 'FormController@store');

    Route::get('/submissions/{form}', 'SubmissionController@index');
    Route::get('/submissions/{form}/{submission}', 'SubmissionController@view');
});


Route::get('/forms/{form}', 'FormController@view');
Route::post('/submissions/{form}', 'SubmissionController@store');
