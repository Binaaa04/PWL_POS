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
        $user = Userm::create([
            'username'=>'manager11',
            'name'=>'Manager11',
            'password' => Hash::make('12345'),
            'level_id'=> 2
        ]);
        $user->username = 'manager12';
        $user->wasChanged(); //true
        $user->wasChanged('username'); //true
        $user->wasChanged('name'); //false
        $user->wasChanged(['name','username']); //true
        dd($user->wasChanged(['name','username']));
    }
    }