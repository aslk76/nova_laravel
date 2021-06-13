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
    return view('auth.login');
});

Auth::routes();
Route::group(['middleware' => ['auth', 'banker']], function() {
    Route::get('/mplus', 'HomeController@mplus')->name('mplus');
    Route::get('/various', 'HomeController@various')->name('various');
    Route::get('/archives/mplus', 'HomeController@mplusArchives')->name('mplus');
    Route::get('/archives/various', 'HomeController@variousArchives')->name('various');
    Route::get('/missing/mplus', 'HomeController@mplusMissing')->name('mplus');
    Route::get('/missing/various', 'HomeController@variousMissing')->name('various');
    Route::get('/balanceops', 'HomeController@balanceops')->name('balanceops');
    Route::get('/topboosters', 'HomeController@topboosters')->name('topboosters');
    Route::get('/statistics', 'HomeController@statistics')->name('statistics');

    // ######################### MPLUS ROUTES ####################################
    Route::get('/getAllMplus/{id}', 'DatabaseController@getAllMplus');
    Route::get('/getSpecificMplus/{id}', 'DatabaseController@getSpecificMplus');
    Route::get('/getAllAllianceMplus/{id}', 'DatabaseController@getAllAllianceMplus');
    Route::get('/getAllHordeMplus/{id}', 'DatabaseController@getAllHordeMplus');

    Route::post('/saveRunMplus', 'DatabaseController@saveRunMplus');
    Route::post('/changeCheckboxMplus', 'DatabaseController@changeCheckboxMplus');
    // ###########################################################################

    // ######################### VARIOUS ROUTES ####################################
    Route::get('/getAllVarious/{id}', 'DatabaseController@getAllVarious');
    Route::get('/getSpecificVarious/{id}', 'DatabaseController@getSpecificVarious');
    Route::get('/getAllAllianceVarious/{id}', 'DatabaseController@getAllAllianceVarious');
    Route::get('/getAllHordeVarious/{id}', 'DatabaseController@getAllHordeVarious');

    Route::post('/saveRunVarious', 'DatabaseController@saveRunVarious');
    Route::post('/changeCheckboxVarious', 'DatabaseController@changeCheckboxVarious');
    // ###########################################################################

    // ######################### MPLUS ARCHIVES ROUTES ####################################
    Route::get('/getAllArchivesMplus', 'DatabaseController@getAllArchivesMplus');
    Route::get('/getAllAllianceArchivesMplus', 'DatabaseController@getAllAllianceArchivesMplus');
    Route::get('/getAllHordeArchivesMplus', 'DatabaseController@getAllHordeArchivesMplus');
    // ###########################################################################

    // ######################### VARIOUS ARCHIVES ROUTES ####################################
    Route::get('/getAllArchivesVarious', 'DatabaseController@getAllArchivesVarious');
    Route::get('/getAllAllianceArchivesVarious', 'DatabaseController@getAllAllianceArchivesVarious');
    Route::get('/getAllHordeArchivesVarious', 'DatabaseController@getAllHordeArchivesVarious');
    // ###########################################################################

    // ######################### MPLUS MISSING ROUTES ####################################
    Route::get('/getAllMissingMplus', 'DatabaseController@getAllMissingMplus');
    Route::get('/getAllAllianceMissingMplus', 'DatabaseController@getAllAllianceMissingMplus');
    Route::get('/getAllHordeMissingMplus', 'DatabaseController@getAllHordeMissingMplus');
    // ###########################################################################

    // ######################### VARIOUS MISSING ROUTES ####################################
    Route::get('/getAllMissingVarious', 'DatabaseController@getAllMissingVarious');
    Route::get('/getAllAllianceMissingVarious', 'DatabaseController@getAllAllianceMissingVarious');
    Route::get('/getAllHordeMissingVarious', 'DatabaseController@getAllHordeMissingVarious');
    // ###########################################################################

    // ######################### STATISTICS ROUTES ####################################
    Route::get('/getSales', 'DatabaseController@getSales');
    Route::get('/getEarns', 'DatabaseController@getEarns');
    Route::get('/getTotal', 'DatabaseController@getTotal');
    // ###########################################################################
});
Route::group(['middleware' => ['auth', 'manager']], function() {
    // ######################### BALANCE OPERATIONS ROUTES ####################################
    Route::get('/getBalanceOps/{id}', 'DatabaseController@getBalanceOps');
    Route::get('/topboosters/{faction}/{id}', 'DatabaseController@getTopBoosters');
    // ###########################################################################
});

