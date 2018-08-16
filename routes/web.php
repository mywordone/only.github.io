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
Route::get('public/login', 'Admin\PublicController@login') -> name('login');
Route::get('public/check', 'Admin\PublicController@check') -> name('check');

Route::get(['prefix' => 'admin'], function (){



});




