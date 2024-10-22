<?php 

use App\Http\Route;

Route::get('/',                     'HomeController@index');
Route::post('/users/create',        'UserController@store');
Route::post('/users/login',         'UserController@login');
Route::get('/users/fetch',          'UserController@fetch');
Route::get('/users/fetchall',          'UserController@fetchAll');
Route::put('/users/update',         'UserController@update');
Route::delete('/users/{id}/delete', 'UserController@remove');
Route::get('/cliente/fetch',          'ClienteController@fetch');
Route::get('/cliente/fetchall',          'ClienteController@fetchAll');
Route::post('/cliente/create',        'ClienteController@store');
