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
    Route::get('/projects/create','ProjectController@create')->name('projects.create');
    Route::get('/projects/{project}','ProjectController@show')->name('projects.show');
    Route::post('/projects', 'ProjectController@store')->name('projects.store');
    Route::get('/home', 'HomeController@index')->name('home')->name('dashboard.home');
});


Auth::routes();

