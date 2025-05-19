<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Userm;


class UserController extends Controller
{
    public function index(){
        return Userm::all();
    }

    public function store(Request $request){
        $user = Userm::create($request->all());

        return response()->json($user, 201);
    }

    public function show(Userm $user){
        return Userm::find($user);
    }

    public function update(Request $request, $user_id)
    {
        $user = Userm::where('user_id', $user_id)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $user->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data updated successfully',
            'data' => $user
        ]);
    }

    public function destroy($user_id)
    {
        $user = Userm::where('user_id', $user_id)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data deleted successfully'
        ]);
    }

}