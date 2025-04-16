<?php
 namespace App\Http\Controllers;
 use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
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
          return redirect('/barang')->with('success', 'item data succesfully added');
      }


      public function show(string $id)
      {
          $item = Barangm::with('kategori')->find($id);
  
          $breadcrumb = (object)[
              'title' => 'Detail Item',
              'list' => ['Home', 'Item', 'Detail']
          ];
  
          $page = (object)[
              'title' => 'detail Item'
          ];
          $activeMenu = 'item';
          return view('item.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'item' => $item, 'activeMenu' => $activeMenu]);
      }

      public function edit($id)
      {
          $barang = Barangm::find($id);
          $kategori = Kategorim::all();
  
          $breadcrumb = (object)[
              'title' => 'Item ',
              'list' => ['Home', 'Item', 'Edit']
          ];
          $page = (object)[
              'title' => 'Edit Item'
          ];
          $activeMenu = 'barang'; //set menu yang sedang aktif
  
          return view('item.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
      }

      public function update(Request $request, string $id)
      {
          $request->validate([
              'barang_kode' => 'required|string|max:10',
              'barang_nama' => 'required|string|max:100',
              'harga_beli' => 'required|integer',
              'harga_jual' =>'required|integer',
              'kategori_id' => 'required|integer'
          ]);
          Barangm::find($id)->update([
              'barang_kode' => $request->barang_kode,
              'barang_nama' => $request->barang_nama,
              'harga_beli' => $request->harga_beli,
              'harga_jual' => $request->harga_jual,
              'kategori_id' => $request->kategori_id
          ]);
          return redirect('/barang')->with('success', 'Successful change data');
      }

      public function destroy(string $id)
      {
          $check = Barangm::find($id);
          if (!$check) {
              return redirect('/barang')->with('error', 'Data not found');
          }
          try {
              Barangm::destroy($id);
              return redirect('/barang')->with('success', 'item data successful deleted');
          } catch (\Illuminate\Database\QueryException $e) {
              //jika terjadi error ketika menghapus data, redirect kembali ke halaman dgn membaa pesan error
              return redirect('/barang')->with('error', 'item data failed deleted because there is another table connected with this data');
          }
      }
     }
