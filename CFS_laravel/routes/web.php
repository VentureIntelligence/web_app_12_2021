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

Route::get('/','CFS\LoginController@index');

// Auth::routes();

Route::get('/home', 'Cfs\HomeController@index')->name('home');
Route::get('/changepassword', 'Cfs\HomeController@changepassword')->name('cp');
Route::post('/changep', 'Cfs\HomeController@change')->name('cp_post');

Route::get('login','CFS\LoginController@index')->name('login');
Route::post('login','CFS\LoginController@login')->name('login');
Route::post('logout','CFS\LoginController@index')->name('logout');
Route::get('register','CFS\LoginController@index')->name('register');
Route::get('company','CFS\CompanyProfileController@company')->name('company');
Route::get('companylist','CFS\CompanyProfileController@allCompanies')->name('companylist');
Route::get('sectorlist','CFS\CompanyProfileController@getSectors')->name('sector.list');