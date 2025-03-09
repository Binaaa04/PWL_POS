<?php

namespace App\Http\Controllers;
use App\Models\Userm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Termwind\Components\Dd;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    public function index(){
        $user = Userm::where('level_id',[2,1,3])->count();
        dd($user);
        return view('user',['data'=>$user]);
    }
    }