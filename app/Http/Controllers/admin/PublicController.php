<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublicController extends Controller
{
    //
    public function index(){
        return view('admin.public.index');
    }

    public function check(Request $request){
        $validatedData = $request->validate([
            'username' => 'required|max:25',
            'password' => 'required|max:25|min:6'
        ]);
        return redirect();
    }
}
