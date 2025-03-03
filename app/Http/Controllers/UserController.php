<?php

namespace App\Http\Controllers;
use App\Models\Userm;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    public function index(){
    //akses model ke userm
        $user = userm::all();
        return view('user',['data'=>$user]);
    }
    }