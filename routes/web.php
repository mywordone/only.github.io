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



<<<<<<< HEAD
//后台首页登录
Route::get('admin/public/login', 'Admin\PublicController@login') -> name('admin_login');
Route::get('admin/public/check', 'Admin\PublicController@check') -> name('admin_check');

Route::group(['prefix' => 'admin'], function (){
	Route::any('matchdata/import', 'admin\MatchDataController@import')->name('matchdata_import');
	Route::get('matchdata/export', 'admin\MatchDataController@export')->name('template_export');
	Route::get('matchdata/index', 'admin\MatchDataController@index')->name('matchdata_index');
=======

//登录首页
Route::get('admin/public/login', 'Admin\PublicController@login') -> name('admin_login');
Route::post('admin/public/check', 'Admin\PublicController@check') -> name('admin_check');

Route::group(['prefix' => 'admin'],function (){
    //登录后台首页
    Route::get('index/index','admin\IndexController@index')->name('index_index');
    Route::get('index/welcome','admin\IndexController@welcome')->name('index_welcome');

    //
>>>>>>> 06feaf2db83f9ae729c65e7eb658c6764d19c39c
});






