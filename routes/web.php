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

Route::get('/', 'ExamController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UserController');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/import/users', 'StudentsController@index')->name('importUsers');
Route::get('/import/tests', 'TestsController@index')->name('importTests');

Route::get('/exam/info', 'ExamController@info');
Route::get('/exam/login', 'ExamController@login');