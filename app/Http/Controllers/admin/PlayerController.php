<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class PlayerController extends Controller
{
    //
    public function index()
    {
        return view('admin.player.index');
    }

    public function add()
    {
        if (Input::Method() == 'POST'){
            //post
        }else{
            //get请求
            return view('admin.player.add');
        }

    }
}
