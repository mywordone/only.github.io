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
Route::get('admin/index/index','admin\IndexController@index')->name('admin.index.index');
Route::get('admin/index/welcome','admin\IndexController@welcome')->name('admin.index.welcome');
=======
//后台首页登录
Route::get('admin/public/login', 'Admin\PublicController@login') -> name('admin_login');
Route::get('admin/public/check', 'Admin\PublicController@check') -> name('admin_check');

Route::group(['prefix' => 'admin'], function (){



});
>>>>>>> c83de8a5e24c849a5ea7fd0070eed598c2d04fa3




