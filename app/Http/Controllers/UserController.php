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
        $user = Userm::firstOrCreate([
            'username'=>'manager',
            'name'=>'Manager'
        ]);
        return view('user',['data'=>$user]);
    }
    }