<?php

use Illuminate\Support\Facades\Route;

Route::get('/', 'HomeController@index')->name('login');

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'auth'], function () {
    Route::resource('project', 'ProjectController');
    Route::resource('project.task', 'ProjectTaskController');
    Route::post('project/{project}/invitations', 'ProjectInvitationController@store')->name('project.invitations');
});
