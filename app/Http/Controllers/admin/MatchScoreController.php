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
    		$matchinfos = DB::select("select a.name as playerAname,b.name as playerBname,m.*,c.* from player as a,player as b,matchinfo as m left join score as c on (m.id = c.match_id and c.status = 0) where m.playerA_id = a.id and m.playerB_id = b.id");
    		return view('admin.matchscore.index',compact('matchinfos',
				'match_id'));
    	}else{
    		$match_id = $res->input('matchname');

    		$matchinfos = DB::select("select a.name as playerAname,b.name as playerBname,m.*,c.* from player as a,player as b,matchinfo as m left join score as c on (m.id = c.match_id and c.status = 0) where m.playerA_id = a.id and m.playerB_id = b.id and m.id = :id",['id'=>$match_id]);
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
