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
            //判断
            if (DB::table('message')->insert($data)){
                $response = ['code' => '0', 'msg' => '添加成功'];
            }else{
                $response = ['code' => '1', 'msg' => '添加失败'];
            }
            return response()->json($response);
        }else{
            //get请求
            return view('admin.message.add');
        }
    }

    //更新方法
    public function update(Request $request)
    {
        //获取id
        $id = $request -> id;
        if ($request->method() == 'POST'){
            //post
            $res = $request->all();
            unset($res['_token']);
            // dd(DB::table('message')->where('id',$id)->update($res));
            if (DB::table('message')->where('id',$id)->update($res)){
                $response = ['code'=>'0', 'msg'=> '更新成功'];
            }else{
                $response = ['code'=>'1', 'msg'=> '更新失败'];
            }
            return response() -> json($response);
        }else {
            //get请求
            $data = DB::table('message')->where('id', $id)->get();
            foreach ($data as $v) {
                return view('admin.message.update', compact('v'));
            }
        }
    }
}
