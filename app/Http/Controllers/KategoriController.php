<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index(){
   /* $data=[
        'kategori_kode'=>'MKP',
        'kategori_nama'=>'Makeup',
        'created_at'=>now()
    ];
    DB::table('m_kategori')->insert($data);
    return 'Insert a new data successful!';*/

    $row = DB::table('m_kategori')->where('kategori_kode','MKP')->update(['kategori_nama'=>'Sunscreen']);
    return 'Update data succesfull!. Total data was updated:'.$row.'baris';
}
}
