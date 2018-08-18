<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
// use Storage;

class PlayerController extends Controller
{
    //首页显示方法
    public function index()
    {
        $data = DB::table('user')->where('status','1')->get();
        return view('admin.player.index',compact('data'));
    }
    //添加头像方法
    public function upload(Request $request)
    {
        if($request->file('file')->isValid() && $request->hasFile('file')){
            $path = $request->file('file')->store('/','public');
            return response()->json(['code'=>'0','msg'=>'上传成功','path'=>'/storage/' . $path]);
        }else{
            return response()->json(['code'=>'1','msg'=>'上传失败']);
        }
    }
    //添加方法
    public function add(Request $request)
    {
        if ($request->method() == 'POST'){
            //post
            $res = $request->all();
            unset($res['file']);
            unset($res['_token']);
            // if ($res['hand'] == '1') {
            //     $res['hand'] = '左手';
            // }else {
            //     $res['hand'] = '右手';
            // }

            // if ($res['sex'] == '1') {
            //    $res['sex'] = '男';
            // }else {
            //     $res['sex'] = '女';
            // }
            // dd(DB::table('user')->insert($res));
            if (DB::table('user')->insert($res)){
                $response = ['code'=>'0', 'msg'=> '添加成功'];
            }else{
                $response = ['code'=>'1', 'msg'=> '添加失败'];
            }
            return response() -> json($response);
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
        // $data = DB::table('user')->where('id',$id);
        // $bool = Storage::disk('public')->delete('$data['image']');
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
        if ($request->method() == 'POST'){
            //post
            // $data = $request->file('file');
            // DB::table('user')->insert($data);
            $res = $request->all();
            unset($res['file']);
            unset($res['_token']);
            // dd(DB::table('user')->where('id',$id)->update($res));
            if (DB::table('user')->where('id',$id)->update($res)){
                $response = ['code'=>'0', 'msg'=> '更新成功'];
            }else{
                $response = ['code'=>'1', 'msg'=> '更新失败'];
            }
            return response() -> json($response);
        }else{
            //get请求
            $data = DB::table('user')->where('id',$id)->get();
            foreach ($data as $v){
                return view('admin.player.update',compact('v'));
            }
        }
    }
}
