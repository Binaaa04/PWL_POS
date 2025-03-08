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
        //insert data using Eloquent Model
        $data=[
            'level_id'=> 2,
            'username'=>'Manager_dua',
            'name'=>'Manager 2',
           'password'=>HASH::make('12345'),
        ];

        Userm::create($data);
        $user = Userm::all();
        return view('user',['data'=>$user]);
    }
    }