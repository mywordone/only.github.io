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




//后台首页登录
Route::get('admin/public/login', 'Admin\PublicController@login') -> name('admin_login');
Route::any('admin/public/check', 'Admin\PublicController@check') -> name('admin_check');

Route::group(['prefix' => 'admin'], function (){
	Route::any('matchdata/import', 'admin\MatchDataController@import')->name('matchdata_import');
	Route::get('matchdata/export', 'admin\MatchDataController@export')->name('template_export');
	Route::get('matchdata/index', 'admin\MatchDataController@index')->name('matchdata_index');
	Route::get('index/index','admin\IndexController@index')->name('index_index');
    Route::get('index/welcome','admin\IndexController@welcome')->name('index_welcome');

    //运动员列表和添加
    Route::get('player/index','Admin\PlayerController@index')->name('player_index');
    Route::any('player/add','Admin\PlayerController@add')->name('player_add');
    Route::any('player/upload','Admin\PlayerController@upload')->name('player_upload');
    Route::any('player/update','Admin\PlayerController@update')->name('player_update');
    Route::get('player/del','Admin\PlayerController@del')->name('player_delete');

    //比赛信息列表
    Route::get('massage/index', 'Admin\MassageController@index')->name('massage_age');
    Route::get('massage/del', 'Admin\MassageController@del')->name('massage_del');
    Route::get('massage/add', 'Admin\MassageController@add')->name('massage_add');
    Route::get('massage/update', 'Admin\MassageController@update')->name('massage_update');
});






