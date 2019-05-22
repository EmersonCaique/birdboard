<?php


Route::get('/', 'HomeController@index')->name('login');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function(){
    Route::resource('project', 'ProjectController');
    Route::resource('project.task', 'ProjectTaskController');

});
