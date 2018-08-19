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
Route::get('admin/public/check', 'Admin\PublicController@check') -> name('admin_check');

Route::group(['prefix' => 'admin'], function (){
	//比赛数据导入
	Route::any('matchdata/import', 'admin\MatchDataController@import')->name('matchdata_import');
	//文件上传
	Route::post('matchdata/uploader', 'admin\MatchDataController@uploader')->name('matchdata_uploader');
	//模板下载
	Route::get('matchdata/export', 'admin\MatchDataController@export')->name('template_export');
	//显示比赛数据列表
	Route::any('matchdata/index', 'admin\MatchDataController@index')->name('matchdata_index');
	//比赛数据添加
	Route::any('matchdata/add', 'admin\MatchDataController@add')->name('matchdata_add');
	// 比赛数据修改
	Route::any('matchdata/edit', 'admin\MatchDataController@edit')->name('matchdata_edit');
	// 比赛数据删除
	Route::get('matchdata/delete', 'admin\MatchDataController@delete')->name('matchdata_delete');
	//获取比赛成绩
	Route::any('matchscore/index','admin\MatchScoreController@index')->name('matchscore_index');
	//上线
	Route::get('matchscore/upline','admin\MatchScoreController@upline')->name('matchscore_upline');
	//下线
	Route::get('matchscore/downline','admin\MatchScoreController@downline')->name('matchscore_downline');

	Route::get('index/index','admin\IndexController@index')->name('index_index');
    Route::get('index/welcome','admin\IndexController@welcome')->name('index_welcome');

});






