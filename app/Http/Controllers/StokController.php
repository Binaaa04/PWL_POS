<?php
 namespace App\Http\Controllers;
 use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Barangm;
use App\Models\Userm;
use App\Models\Stok;

class StokController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Stock List',
            'list' => ['Home', 'Stock']
        ];
        $page = (object)[
            'title' => 'Stock list integreted in system'
        ];
        $activeMenu = 'stok '; //set menu yang sedang aktif

        $barang = Barangm::all(); //ambil data barang utk filter barang
        $user = Userm::all();

        return view('stok.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu, 'user' => $user]);
    }

    public function list(Request $request)
    {
         $stok = Stok::select('stok_id', 'stok_tanggal', 'stok_jumlah','barang_id','user_id')->with('barang', 'user');
    
         return DataTables::of($stok)
             ->addIndexColumn()  // menambah/ `n kolom index / no urut (default name kolom: DT_RowIndex)  
             ->addColumn('action', function ($stok) {  // menambahkan kolom action  
                 $btn  = '<a href="'.url('/stok/' . $stok->stok_id).'" class="btn btn-info btn-sm">Detail</a> '; 
                  $btn .= '<a href="'.url('/stok/' . $stok->stok_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';  
             $btn .= '<form class="d-inline-block" method="POST" action="'. url('/stok/'.$stok->stok_id).'">'  
                     . csrf_field() . method_field('DELETE') .   
                     '<button type="submit" class="btn btn-danger btn-sm" onclick="return 
                        confirm(\'Are u sure want to delete this data?\');">Delete</button></form>';
                        return $btn;
                        })
                        ->rawColumns(['action']) // memberitahu bahwa kolom action adalah html  
                        ->make(true);
                        }

}