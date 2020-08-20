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
Route::group(
	['namespace' => 'Admin', 'prefix' => 'admin'],
	function () {
        Route::get('dashboard', 'DashboardController@index');
        Route::get('/categories','CategoryController@index')->name('admin.categories.home');
        Route::get('/categories/create','CategoryController@create')->name('admin.categories.create');
    }
    );
