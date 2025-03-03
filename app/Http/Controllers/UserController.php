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
            'name'=>'pelanggan pertama',
        ];
        //tambahkan data ke tabel m_user
        Userm::where('username','Customer')->update($data);         //akses model ke userm
        $user = Userm::all();
        return view('user',['data'=>$user]);
    }
    }