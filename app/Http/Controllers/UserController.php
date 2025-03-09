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
        $user = Userm::firstOrNew([
            'username'=>'manager33',
            'name'=>'Manager Tiga Tiga',
            'password' => Hash::make('12345'),
            'level_id'=> 2
        ]);
        $user->save();
        return view('user',['data'=>$user]);
    }
    }