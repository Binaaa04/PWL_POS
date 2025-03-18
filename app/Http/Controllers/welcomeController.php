<?php
namespace App\Http\Controllers;
class WelcomeController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title'=>'selamat datang',
            'list'=>['home','welcome']
        ];
        $activeMenu = 'dashboard';
        return view('welcome', [
            'breadcrumb' => $breadcrumb,
            'activeMenu' => $activeMenu
        ]);
        
    }
}