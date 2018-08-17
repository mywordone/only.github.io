<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MatchDataController extends Controller
{
	public function index(){
		return view('admin.matchdata.index');
	}
    //比赛数据批量上传
    public function import(Request $res){

    	if($res->method() === 'GET' ){
    		//显示批量上传页面
    		return view('admin.matchdata.import');
    	}else{
    		//获取提交数据并保存到数据库
    	}

    }
}
