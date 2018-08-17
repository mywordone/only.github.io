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




//登录首页
Route::get('admin/public/login', 'Admin\PublicController@login') -> name('admin_login');
Route::post('admin/public/check', 'Admin\PublicController@check') -> name('admin_check');

Route::group(['prefix' => 'admin'],function (){
    //登录后台首页
    Route::get('index/index','admin\IndexController@index')->name('index_index');
    Route::get('index/welcome','admin\IndexController@welcome')->name('index_welcome');

    //
});






