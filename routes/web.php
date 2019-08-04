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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('users', 'UserController');
Route::get('/dashboard', 'DashboardController@index')->name('dashboard');


Route::get('/tests', 'TestController@index')->name('tests.index');
Route::get('/import/tests', 'TestController@uploadShow')->name('tests.import');
Route::post('/import/tests', 'TestController@store')->name('tests.store');
Route::delete('/test/{id}', 'TestController@delete')->where(['id' => '[0-9]+'])->name('tests.delete');
Route::get('/test/{id}', 'TestController@edit')->where(['id' => '[0-9]+'])->name('tests.edit');
Route::put('/test/{id}', 'TestController@update')->where(['id' => '[0-9]+'])->name('tests.update');

Route::get('/students', 'StudentsController@index')->name('importUsers');
Route::get('/import/users/upload', 'StudentsController@uploadShow')->name('importUsersShowUpload');
Route::post('/import/users/upload', 'StudentsController@uploadFile')->name('importUsersShowUploadFile');
Route::delete('/student/{id}', 'StudentsController@delete')->where(['id' => '[0-9]+'])->name('student.delete');
Route::get('/student/{id}', 'StudentsController@edit')->where(['id' => '[0-9]+'])->name('student.edit');
Route::put('/student/{id}', 'StudentsController@update')->where(['id' => '[0-9]+'])->name('student.update');
Route::get('/student/generate/access', 'StudentsController@generateAccess')->name('student.generate');
Route::get('/student/print/access', 'StudentsController@printAccess')->name('student.print');

Route::get('/exam', 'ExamController@index')->name('exam.tests');
Route::get('/', 'ExamController@login')->name('exam.main');
Route::get('/exam/info', 'ExamController@info')->name('exam.info');
Route::post('/exam/login', 'ExamController@handleLogin')->name('exam.login');
Route::get('/exam/json/questions', 'ExamController@questionDataJSON');
Route::post('/exam/json/finish', 'ExamController@finishExam');
Route::get('/exam/results', 'ExamController@resultPage');

Route::get('/settings/language', 'LanguageController@index')->name('language.index');
Route::post('/settings/language', 'LanguageController@store')->name('language.create');
Route::delete('/settings/language/{id}', 'LanguageController@delete')->where(['id' => '[0-9]+'])->name('language.delete');

Route::get('/results', 'ResultController@index')->name('result.index');
Route::get('/results/{id}', 'ResultController@view')->where(['id' => '[0-9]+'])->name('result.show');
Route::get('/results/export', 'ResultController@exportXLS')->name('result.export');
Route::get('/result/edit/{id}', 'ResultController@edit')->where(['id' => '[0-9]+'])->name('result.edit');
Route::put('/result/{id}', 'ResultController@store')->where(['id' => '[0-9]+'])->name('result.update');

Route::get('/corrects', 'CorrectController@index')->name('correct.index');
Route::get('/correct/import', 'CorrectController@import')->name('correct.import');
Route::post('/correct/import', 'CorrectController@handleImport')->name('correct.store');