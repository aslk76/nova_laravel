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

Route::get('/mplus', 'HomeController@mplus')->name('mplus');
Route::get('/various', 'HomeController@various')->name('mplus');
Route::get('/archives/mplus', 'HomeController@mplusArchives')->name('mplus');
Route::get('/archives/various', 'HomeController@variousArchives')->name('mplus');

// ######################### MPLUS ROUTES ####################################
Route::get('/getAllMplus', 'DatabaseController@getAllMplus');
Route::get('/getSpecificMplus/{id}', 'DatabaseController@getSpecificMplus');
Route::get('/getAllAllianceMplus', 'DatabaseController@getAllAllianceMplus');
Route::get('/getAllHordeMplus', 'DatabaseController@getAllHordeMplus');

Route::post('/changeCheckboxMplus', 'DatabaseController@changeCheckboxMplus');
// ###########################################################################

// ######################### VARIOUS ROUTES ####################################
Route::get('/getAllVarious', 'DatabaseController@getAllVarious');
Route::get('/getSpecificVarious/{id}', 'DatabaseController@getSpecificVarious');
Route::get('/getAllAllianceVarious', 'DatabaseController@getAllAllianceVarious');
Route::get('/getAllHordeVarious', 'DatabaseController@getAllHordeVarious');

Route::post('/changeCheckboxVarious', 'DatabaseController@changeCheckboxVarious');
// ###########################################################################

// ######################### MPLUS ARCHIVES ROUTES ####################################
Route::get('/getAllArchivesMplus', 'DatabaseController@getAllArchivesMplus');
Route::get('/getSpecificArchivesMplus/{id}', 'DatabaseController@getSpecificArchivesMplus');
Route::get('/getAllAllianceArchivesMplus', 'DatabaseController@getAllAllianceArchivesMplus');
Route::get('/getAllHordeArchivesMplus', 'DatabaseController@getAllHordeArchivesMplus');

Route::post('/changeCheckboxArchivesMplus', 'DatabaseController@changeCheckboxArchivesMplus');
// ###########################################################################

// ######################### VARIOUS ARCHIVES ROUTES ####################################
Route::get('/getAllArchivesVarious', 'DatabaseController@getAllArchivesVarious');
Route::get('/getSpecificArchivesVarious/{id}', 'DatabaseController@getSpecificArchivesVarious');
Route::get('/getAllAllianceArchivesVarious', 'DatabaseController@getAllAllianceArchivesVarious');
Route::get('/getAllHordeArchivesVarious', 'DatabaseController@getAllHordeArchivesVarious');

Route::post('/changeCheckboxArchivesVarious', 'DatabaseController@changeCheckboxArchivesVarious');
// ###########################################################################
