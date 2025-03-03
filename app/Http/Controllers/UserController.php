<?php

namespace App\Http\Controllers;
use App\Models\Userm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    public function index(){
        //insert data using Eloquent Model
        $data=[
            'level_id'=> 3,
            'username'=>'kasir',
            'name'=>'staff/kasir',
           'password'=>HASH::make('12345'),
        ];
        //tambahkan data ke tabel m_user
        Userm::insert($data);         //akses model ke userm
        $user = Userm::all();
        return view('user',['data'=>$user]);
    }
    }