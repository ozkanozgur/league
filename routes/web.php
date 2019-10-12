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

Route::get('/', 'HomeController@index');
Route::get('/ajax/champ-percentage', 'AjaxController@champPercantages')->name('getchampperc');
Route::get('/ajax/make-match', 'AjaxController@makeMatch')->name('makematch');
Route::get('/ajax/play-all', 'AjaxController@playAll')->name('playall');
Route::get('/ajax/reset-league', 'AjaxController@resetLeague')->name('resetleague');
Route::get('/ajax/load-league-table', 'AjaxController@loadLeagueTable')->name('loadleaguetable');
Route::get('/ajax/load-fixtures-table', 'AjaxController@loadFixtures')->name('loadfixtures');
