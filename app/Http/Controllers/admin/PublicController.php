<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class PublicController extends Controller
{
    //
    public function login(){
        return view('admin.public.login');
    }

    public function check(Request $request){
        //自动验证
        $this->validate($request,[
            'admin' => 'required|max:20',
            'password' => 'required|max:25|min:6'
        ]);

        $data = $request->only(['admin','password']);
        $bool = DB::table('admin')->where('admin',$data['admin'])->where('password',$data['password'])->get();
//        dd($bool);
        //认证
        if ($bool){
//            dd('123');
            //认证通过
            return redirect( route('index_index') );
        }else{
            //认证不通过
//            dd('456');
            return redirect(route('admin_login'));
        }

    }
}
