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

Route::get('/', 'App\Http\Controllers\MainController@articles')->name('main_page');
Route::get('/article/{id}', 'App\Http\Controllers\MainController@article')->name('article_show');

Route::get('/catalog', 'App\Http\Controllers\MainController@catalog')->name('catalog_page');
Route::get('/product/{id}', 'App\Http\Controllers\MainController@product')->name('product_show');

Route::get('/contacts', 'App\Http\Controllers\MainController@contacts')->name('contacts_page');
Route::get('/about', 'App\Http\Controllers\MainController@about')->name('about_page');
