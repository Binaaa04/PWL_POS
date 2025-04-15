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

    public function show(string $id)
    {
        $stok = Stok::with('barang', 'user')->find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Stock',
            'list' => ['Home', 'Stock', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Stock'
        ];
        $activeMenu = 'stok';
        return view('stok.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'stok' => $stok, 'activeMenu' => $activeMenu]);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Add New Stock',
            'list' => ['Home', 'Stock', 'Add Data']
        ];
        $page = (object)[
            'title' => 'Add new Stock data'
        ];
        $user = Userm::all();
        $barang = Barangm::all(); //ambil data kategori untuk ditampilkan di form
        $activeMenu = 'stok'; //set menu yang sedang aktif
        return view('stok.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'user' => $user,'activeMenu' => $activeMenu]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'stok_tanggal' => 'required|string|min:3',
            'stok_jumlah' => 'required|string|max:100',
            'user_id' => 'required|integer',
            'barang_id' => 'required|integer'
        ]);

        Stok::create([
            'stok_tanggal' => $request->stok_tanggal,
            'stok_jumlah' => $request->stok_jumlah,
            'user_id' => $request->user_id,
            'barang_id' => $request->barang_id
        ]);
        return redirect('/stok')->with('success', 'Stock data succesfully added');
    }

}