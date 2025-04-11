<?php
 namespace App\Http\Controllers;
 use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Barangm;
use App\Models\Kategorim;

 class BarangController extends Controller
 {
     public function index()
     {
            $breadcrumb = (object)[
              'title' => 'Item Data ',
              'list' => ['Home', 'Item']
          ];
          $page = (object)[
              'title' => 'Item list integreted in system'
          ];
          $activeMenu = 'item'; //set menu yang sedang aktif
      
          $kategori = Kategorim::all();
      
          return view('item.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'kategori'=>$kategori]);
          }

          public function list(Request $request)
          {
              $barangs = Barangm::select('barang_id', 'barang_kode', 'barang_nama', 'harga_jual','harga_beli','kategori_id')->with('kategori');
         
              return DataTables::of($barangs)
                  ->addIndexColumn()  // menambahkan kolom index / no urut (default name kolom: DT_RowIndex)  
                  ->addColumn('action', function ($barang) {  // menambahkan kolom action  
                      $btn  = '<a href="'.url('/barang/' . $barang->barang_id).'" class="btn btn-info btn-sm">Detail</a> '; 
                       $btn .= '<a href="'.url('/barang/' . $barang->barang_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';  
                  $btn .= '<form class="d-inline-block" method="POST" action="'. url('/barang/'.$barang->barang_id).'">'  
                          . csrf_field() . method_field('DELETE') .   
                          '<button type="submit" class="btn btn-danger btn-sm" onclick="return 
      confirm(\'Are u sure want to delete this data?\');">Delete</button></form>';
      return $btn;
      })
      ->rawColumns(['action']) // memberitahu bahwa kolom action adalah html  
      ->make(true);
      }
     }
