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

Route::get('admin/index/index','admin\IndexController@index')->name('admin.index.index');
Route::get('admin/index/welcome','admin\IndexController@welcome')->name('admin.index.welcome');



