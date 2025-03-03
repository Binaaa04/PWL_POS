<?php

namespace App\Http\Controllers;
use App\Models\Userm;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    public function index(){
        //insert data using Eloquent Model
        $data=[
            'username'=>'Customer',
            'nama'=>'Emina',
           'password'=>HASH::make('12345'),
            'level_id'=> 4
        ];
        //tambahkan data ke tabel m_user
        userm::insert($data);         //akses model ke userm
        $user = userm::all();
        return view('user',['data'=>$user]);
    }
    }