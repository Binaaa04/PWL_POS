<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login()
    {
        if (Auth::check()) {
            return redirect('/');
        }
        return view('auth.login');
    }

    public function postlogin(Request $request)
    {
        $credentials = $request->only('username', 'password');
    
        if (Auth::attempt($credentials)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Login success',
                    'redirect' => url('/')
                ]);
            }
            return redirect('/'); // login success via form biasa
        }
    
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => false,
                'message' => 'Failed Login'
            ]);
        }
    
        return redirect(to: 'login')->withErrors(['login' => 'Incorrect username or password']);
    }

public function postregister(Request $request)
{
    $validatedData = $request->validate([
        'username' => 'required|string|max:255|unique:m_user',
        'name' => 'required|string|max:255',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // Ambil level_id dari level_nama = 'Customer'
    $level = \App\Models\Levelm::where('level_nama', 'Customer')->first();

    if (!$level) {
        return back()->withErrors(['role' => 'Customer Role not found']);
    }

    $user = \App\Models\Userm::create([
        'level_id' => $level->level_id,
        'username' => $validatedData['username'],
        'name' => $validatedData['name'],
        'password' => bcrypt($validatedData['password']),
    ]);

    Auth::login($user);

    return redirect('/');
}


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
