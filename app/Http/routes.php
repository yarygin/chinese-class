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

// Route::group(['prefix' => 'teachers'], function()
// {
//     Route::get('/', function()
//     {
//         return Redirect::to('teachers/list');
//     });
//     Route::get('/list/', ['as'=>'list', 'uses'=>'TeacherController@getList']);
//     Route::get('/{id}', 'TeacherController@getSingle');
//     Route::get('/add', 'TeacherController@add');
// });

Route::resource('teachers', 'TeacherController',
                ['only' => ['index', 'show', 'create', 'store', 'edit', 'update' ]]);

Route::get('/filter', 'TeacherController@filter');
Route::post('/filter/result', 'TeacherController@sharedStudents');

Route::resource('students', 'StudentController',
                ['only' => ['index', 'show', 'create', 'store', 'edit', 'update' ]]);

// Route::group(['prefix' => 'students'], function()
// {
//     Route::get('/', function()
//     {
//         return Redirect::to('students/list');
//     });
//     Route::get('/list/', ['as'=>'list', 'uses'=>'StudentController@getList']);
//     Route::get('/{id}', 'StudentController@getSingle');
//     Route::get('/add', 'StudentController@add');
// });