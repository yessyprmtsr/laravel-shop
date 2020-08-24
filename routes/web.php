<?php

use Illuminate\Support\Facades\Auth;
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
	['namespace' => 'Admin', 'prefix' => 'admin', 'middleware' => ['auth']],
	function () {
        Route::get('dashboard', 'DashboardController@index')->name('admin.dashboard');
        Route::resource('categories', 'CategoryController');
        //product
        Route::resource('products', 'ProductsController');
        Route::get('products/{productID}/images', 'ProductsController@images')->name('products.images');
		Route::get('products/{productID}/add-image', 'ProductsController@add_image')->name('products.add_image');
		Route::post('products/images/{productID}', 'ProductsController@upload_image')->name('products.upload_image');
        Route::delete('products/images/{imageID}', 'ProductsController@remove_image')->name('products.remove_image');
        //attributes
        Route::resource('attributes', 'AttributeController');
        //list option dari attributs
        Route::get('attributes/{attributeID}/options', 'AttributeController@options')->name('attributes.options');
        //menambah option dari kategori
        Route::get('attributes/{attributeID}/add-option', 'AttributeController@add_option')->name('attributes.add_option');
        Route::post('attributes/options/{attributeID}', 'AttributeController@store_option')->name('attributes.store_option');
        //hapus option dari pilihan attributes
        Route::delete('attributes/options/{optionID}', 'AttributeController@remove_option')->name('attributes.remove_option');
        //edit
		Route::get('attributes/options/{optionID}/edit', 'AttributeController@edit_option')->name('attributes.edit_option');
        Route::put('attributes/options/{optionID}', 'AttributeController@update_option')->name('attributes.update_option');
        //roles and user
        Route::resource('roles','RoleController');
        Route::resource('users','UserController');
    }
    );

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
