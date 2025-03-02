<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index(){
      //  DB::insert('insert into m_level(level_kode,level_nama,created_at)values(?,?,?)',['CUS','Customer',now()]);

      //$row = DB::update('update m_level set level_nama=? where level_kode=?',['Pelanggan','CUS']);

     // $row = DB::delete('delete from m_level where level_kode=?',['CUS']);
       // return 'Delete data succesfull!. Total data was deleted:'.$row.'baris';

       $data = DB::select('select * from m_level');
       return view('level',['data' => $data]);
    }
}
