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
                    'message' => 'Login Berhasil',
                    'redirect' => url('/')
                ]);
            }
            return redirect('/'); // login berhasil via form biasa
        }
    
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'status' => false,
                'message' => 'Login Gagal'
            ]);
        }
    
        return redirect(to: 'login')->withErrors(['login' => 'Username atau password salah.']);
    }

public function postregister(Request $request)
{
    $validatedData = $request->validate([
        'username' => 'required|string|max:255|unique:m_user',
        'name' => 'required|string|max:255',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // Ambil level_id dari level_name = 'Customer'
    $level = \App\Models\Levelm::where('level_name', 'Customer')->first();

    if (!$level) {
        return back()->withErrors(['role' => 'Level Customer tidak ditemukan.']);
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
