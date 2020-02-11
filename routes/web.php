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

// Route::get('/', function () {
//     return view('welcome');
// });


// Auth
Route::get('/', 'Auth\LoginController@showLoginForm')->name('home');
Route::post('login', 'Auth\LoginController@login')->name('login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');

// Client part
Route::get('/clients', 'HomeController@index')->name('clients');
Route::get('/client/{id}', 'HomeController@show')->name('show-client');
Route::get('/clients-data', 'HomeController@clientsData')->name('clients-data');
Route::post('/get-client', 'HomeController@getClient')->name('get-client');
Route::get('/save-client', 'HomeController@saveClient')->name('save-client');
Route::get('/destroy-client/{id?}', 'HomeController@destroyClient')->name('client-destroy');
Route::get('/change-status', 'HomeController@changeStatus')->name('change-status');

Route::post('/get-agent', 'HomeController@getAgent')->name('get-agent');
Route::get('/save-agent', 'HomeController@saveAgent')->name('save-agent');

// User part
Route::get('/users', 'HomeController@users')->name('users');
Route::get('/users-data', 'HomeController@usersData')->name('users-data');
Route::post('/get-user', 'HomeController@getUser')->name('get-user');
Route::get('/save-user', 'HomeController@saveUser')->name('save-user');

//Mortgages
Route::get('/mortgages', 'HomeController@mortgages')->name('mortgages');
Route::get('/save-settings', 'HomeController@saveSettings')->name('save-settings');

// Export files
Route::post('/export/calculator/pdf', 'ExportController@calculatorPDF')->name('export_calculator');
Route::get('/export/word/{id}', 'ExportController@exportWord')->name('export_word');

