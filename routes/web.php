<?php

use Illuminate\Support\Facades\Route;

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

Route::View('/','welcome')->name('home.index');

Route::group(['middleware' => 'auth'], function() {
    Route::get('/projects','ProjectController@index')->name('projects.index');
    Route::post('/projects', 'ProjectController@store')->name('projects.store');
    Route::get('/projects/create','ProjectController@create')->name('projects.create');
    Route::get('/projects/{project}/edit','ProjectController@edit')->name('projects.edit');
    Route::get('/projects/{project}','ProjectController@show')->name('projects.show');
    Route::patch('/projects/{project}', 'ProjectController@update')->name('projects.update');

    //Project Tasks
    Route::post('/projects/{project}/tasks','ProjectTasksController@store')->name('projects.tasks.store');
    Route::patch('/projects/{project}/tasks/{task}','ProjectTasksController@update')->name('projects.tasks.update');

    Route::get('/home', 'HomeController@index')->name('home')->name('dashboard.home');
});


Auth::routes();

