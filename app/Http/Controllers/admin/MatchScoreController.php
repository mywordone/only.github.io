<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class MatchScoreController extends Controller
{
    //比赛成绩显示
    public function index(Request $res){
    	$match_id = 0;
    	if($res->method() == 'GET'){
    		$matchinfos = DB::table('matchinfo as m')
			->leftjoin('player as a','m.playerA_id','=','a.id')
			->leftjoin('player as b','m.playerB_id','=','b.id')
			->leftjoin('score as c','m.id','=','c.match_id')
			->select('a.name as playerAname','b.name as playerBname','m.*','c.*')
			->get();
			// dd($matchinfos);
    		return view('admin.matchscore.index',compact('ms','matchinfos',
				'match_id'));
    	}else{
    		$match_id = $res->input('matchname');
    		$matchinfos = DB::table('matchinfo as m')
			->leftjoin('player as a','m.playerA_id','=','a.id')
			->leftjoin('player as b','m.playerB_id','=','b.id')
			->leftjoin('score as c','m.id','=','c.match_id')
			->where('m.id',$match_id)
			->select('a.name as playerAname','b.name as playerBname','m.*','c.*')
			->get();
			return view('admin.matchscore.index',compact('ms','matchinfos',
				'match_id'));
    	}
    }

    //上线
    public function upline(Request $res){
    	$rs = DB::table('matchinfo')->where('id',$res->input('id'))->update(['status' => 0]);
    	if($rs){
    		$response = ['code' => 0, 'msg' => '上线成功'];
    		return response()->json($response);
    	}else{
    		$response = ['code' => 1, 'msg' => '上线失败'];
    		return response()->json($response);
    	}
    }

    //下线
    public function downline(Request $res){
    	$rs = DB::table('matchinfo')->where('id',$res->input('id'))->update(['status' => 1]);
    	if($rs){
    		$response = ['code' => 0, 'msg' => '下线成功'];
    		return response()->json($response);
    	}else{
    		$response = ['code' => 1, 'msg' => '下线失败'];
    		return response()->json($response);
    	}
    }
}
