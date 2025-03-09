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
            'username'=>'manager55',
            'name'=>'Manager55',
            'password' => Hash::make('12345'),
            'level_id'=> 2
        ]);
        $user->username = 'manager56';
        $user->isDirty(); //true
        $user->isDirty('username'); //true
        $user->isDirty('name'); //false
        $user->isDirty(['name','username']); //true
        $user->save();
        $user->isClean(); //false
        $user->isClean('username'); //false
        $user->isClean('name'); //true
        $user->isClean(['name','username']); //false
       dd($user->isDirty());
    }
    }