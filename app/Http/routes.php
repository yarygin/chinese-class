<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::resource('teachers', 'TeacherController',
                ['only' => ['index', 'show', 'create', 'store', 'edit', 'update' ]]);

Route::get('/filter', 'TeacherController@filter');
Route::post('/filter/result', 'TeacherController@uniqueStudents');

Route::resource('students', 'StudentController',
                ['only' => ['index', 'show', 'create', 'store', 'edit', 'update' ]]);