<?php

namespace App\Http\Controllers;
use App\Models\Userm;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    public function index(){
        $data=[
            'username'=>'Customer',
            'nama'=>'Emina',
           'password'=>HASH::make('12345'),
            'level_id'=> 4
        ];
        $user = userm::all();
        return view('user',['data'=>$user]);
    }
    }