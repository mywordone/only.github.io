<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;
use DB;

class PlayerController extends Controller
{
    //首页显示方法
    public function index()
    {
        $data = DB::table('user')->where('status','1')->get();
        return view('admin.player.index',compact('data'));
    }
    //添加方法
    public function add(Request $request)
    {
        if (Input::Method() == 'POST'){
            //post
            
        }else{
            //get请求
            return view('admin.player.add');
        }
    }
    //删除方法
    public function del(Request $request)
    {
        //获取id
        $id = $request -> id;
        $res = DB::table('user')->where('id',$id)->update(['status' => '2']);

        if($res){
            $response = ['err' => 0,'msg' => '删除成功'];
        }else{
            $response = ['err' => 1,'msg' => '删除失败'];
        }
        return response() -> json($response);
    }
    //更新方法
    public function update(Request $request)
    {
        //获取id
        $id = $request -> id;
        if (Input::method() == 'POST'){
            //post
            $data = $request->file('file');
            DB::table('user')->insert($data);
        }else{
            //get请求
            $data = DB::table('user')->where('id',$id)->get();
            foreach ($data as $v){
                return view('admin.player.update',compact('v'));
            }
        }
    }
}
