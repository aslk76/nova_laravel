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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/getAll', 'DatabaseController@getAll');
Route::get('/getSpecificRun/{id}', 'DatabaseController@getSpecificRun');
Route::get('/getAllAllianceRuns', 'DatabaseController@getAllAllianceRuns');
Route::get('/getAllHordeRuns', 'DatabaseController@getAllHordeRuns');

Route::post('/changeCheckbox', 'DatabaseController@changeCheckbox');
