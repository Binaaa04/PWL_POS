<?php
 namespace App\Http\Controllers;
 
 class WelcomeController extends Controller
 {
     public function index()
     {
         $breadcrumb = (object) [
             'title' => 'User List',
             'list' => ['Home', 'User']
         ];
         $page = (object)[
            'title'=>'User list integreted in system'
         ];
 
         $activeMenu = 'user';
 
         return view('user.index', ['breadcrumb' => $breadcrumb, 'activeMenu' => $activeMenu,'page'=>$page]);
     }
 }