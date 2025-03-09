<?php

namespace App\Http\Controllers;
use App\Models\Userm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    public function index(){
        $user = Userm::all();
        return view('user',['data'=>$user]);
    }
    public function adding(){
        return view('user_add');
    }
    public function add_save(Request $request){
        Userm::create([
            'username'=>$request->username,
            'name'=>$request->name,
            'password'=>Hash::make($request->password),
            'level_id'=>$request->level_id
        ]);
        return redirect('/user');
    }
}