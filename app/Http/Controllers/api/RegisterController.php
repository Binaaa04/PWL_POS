<?php

namespace App\Http\Controllers\api;
use App\Models\Userm;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function __invoke(Request $request)
    {
        // set validatoin
        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'name' => 'required',
            'password' => 'required|min:6|confirmed',
            'level_id' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $image = $request->file('image'); 

        // create user
        $user = Userm::create([
            'username' => $request->username,
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id,
            'image' => $image->hashName()
        ]);

        // return response JSON user is created
        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user,
            ], 201);
        }

        // return JSON process insert failed
        return response()->json([
            'success' => false,
        ], 409);
    }
}