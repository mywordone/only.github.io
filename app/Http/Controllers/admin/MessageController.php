<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class MessageController extends Controller
{
    //
    public function index(){
        $data = DB::table('message')
                ->leftJoin('user as ua','ua.id','=','user_a')
                ->leftJoin('user as ub','ub.id','=','user_b')
                ->select('message.*','ua.user_name as aname','ub.user_name as bname')
                ->where('states', '1')
                ->get();
        return view('admin.message.index',compact('data'));
    }

    //删除方法
    public function del(Request $request)
    {
        $id = $request -> id;//获取id
        //判断
        if (DB::table('message')->where('id',$id)->update(['states' => '2'])){
            $response = ['code' => '0', 'msg' => '删除成功'];
        }else{
            $response = ['code' => '1', 'msg' => '删除失败'];
        }
        return response()->json($response);
    }

    //添加方法
    public function add(Request $request)
    {
        if ($request->method() == 'POST'){
            //post
            $data = $request->all();//获取表单数据
            unset($data['_token']);//去除_token值
            $aid = DB::table('user')->where('user_name',$data['user_a'])->value('id');
            $bid = DB::table('user')->where('user_name',$data['user_b'])->value('id');
            $data['user_a'] = $aid;
            $data['user_b'] = $bid;
            $game_stage = DB::table('message')->where('id',$data['game_stage'])->value('game_stage');
            $game_project = DB::table('message')->where('id',$data['game_project'])->value('game_project');
            $data['game_stage'] = $game_stage;
            $data['game_project'] = $game_project;
            //判断
            if (DB::table('message')->insert($data)){
                $response = ['code' => '0', 'msg' => '添加成功'];
            }else{
                $response = ['code' => '1', 'msg' => '添加失败'];
            }
            return response()->json($response);
        }else{
            //get请求
            $data = DB::table('user')->select('user_name')->get();
            $game = DB::table('message')->get();
            return view('admin.message.add',compact('data','game'));
        }
    }

    //更新方法
    public function update(Request $request)
    {
        //获取id
        $id = $request -> id;
        if ($request->method() == 'POST'){
            //post
            $data = $request->all();
            unset($data['_token']);
            $aid = DB::table('user')->where('user_name',$data['user_a'])->value('id');
            $bid = DB::table('user')->where('user_name',$data['user_b'])->value('id');
            $data['user_a'] = $aid;
            $data['user_b'] = $bid;
            // dd(DB::table('message')->where('id',$id)->update($res));
            if (DB::table('message')->where('id',$id)->update($data)){
                $response = ['code'=>'0', 'msg'=> '更新成功'];
            }else{
                $response = ['code'=>'1', 'msg'=> '更新失败'];
            }
            return response() -> json($response);
        }else {
            //get请求
            $data = DB::table('message')->where('id', $id)->get();
            foreach ($data as $v) {
                $a_id = $v->user_a;
                $b_id = $v->user_b;
                $aname = DB::table('user')->where('id',$a_id)->value('user_name');
                $bname = DB::table('user')->where('id',$b_id)->value('user_name');
                return view('admin.message.update', compact('v','aname','bname'));
            }
        }
    }
}
