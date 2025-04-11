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
              $barangs = Barangm::select('barang_id', 'barang_kode', 'barang_nama', 'harga_beli','harga_jual','kategori_id')->with('kategori');
         
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
      public function create()
      {
          $breadcrumb = (object)[
              'title' => 'Add New Item',
              'list' => ['Home', 'Item', 'Add Data']
          ];
          $page = (object)[
              'title' => 'Add new item data'
          ];
          $kategori = Kategorim::all(); //ambil data kategori untuk ditampilkan di form
          $activeMenu = 'item'; //set menu yang sedang aktif
          return view('item.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
      }
      public function store(Request $request)
      {
          $request->validate([
              'barang_kode' => 'required|string|min:3',
              'barang_nama' => 'required|string|max:100',
              'harga_beli' => 'required|integer',
              'harga_jual' => 'required|integer',
              'kategori_id' => 'required|integer'
          ]);
  
          Barangm::create([
              'barang_kode' => $request->barang_kode,
              'barang_nama' => $request->barang_nama,
              'harga_beli' => $request->harga_beli,
              'harga_jual' => $request->harga_jual,
              'kategori_id' => $request->kategori_id
          ]);
          return redirect('/barang')->with('success', 'item data succesfully changed');
      }
     }
