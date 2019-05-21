<?php


Route::resource('project', 'ProjectController');
Route::get('/', 'HomeController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
