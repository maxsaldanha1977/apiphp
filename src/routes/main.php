<?php

use App\Http\Route;

Route::get('/', 'HomeController@index');

Route::post('/users/create', 'UserController@store');
Route::post('/users/login', 'UserController@login');
Route::get('/users/fetch', 'UserController@fetch');
Route::get('/users/fetchall', 'UserController@fetchAll');
Route::put('/users/update', 'UserController@update');
Route::delete('/users/delete/{id}', 'UserController@remove');

Route::post('/cliente/create', 'ClienteController@store');
Route::get('/cliente/fetch/{id}', 'ClienteController@fetch');
Route::get('/cliente/fetchall', 'ClienteController@fetchAll');
Route::put('/cliente/update/{id}', 'ClienteController@update');
Route::delete('/cliente/delete/{id}', 'ClienteController@remove');

Route::post('/endereco/create', 'EnderecoController@store');
Route::get('/endereco/fetch/{id}',  'EnderecoController@fetch');
Route::get('/endereco/fetchall', 'EnderecoController@fetchAll');
Route::put('/endereco/update/{id}', 'EnderecoController@update');
Route::delete('/endereco/delete/{id}', 'EnderecoController@remove');
