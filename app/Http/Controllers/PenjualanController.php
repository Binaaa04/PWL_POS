<?php
 namespace App\Http\Controllers;

use App\Models\Penjualanm;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Userm;

class PenjualanController extends Controller
{
    public function index()
    {
           $breadcrumb = (object)[
             'title' => 'Sales Transaction Data ',
             'list' => ['Home', 'Sales Transaction']
         ];
         $page = (object)[
             'title' => 'Sales Transaction list integreted in system'
         ];
         $activeMenu = 'penjualan'; //set menu yang sedang aktif
     
         $user = Userm::all();
     
         return view('penjualan.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'user'=>$user]);
         }
         public function list(Request $request)
         {
              $penjualans = Penjualanm::select('penjualan_id','pembeli' ,'penjualan_kode', 'penjualan_tanggal','user_id')->with('user');
         
              return DataTables::of($penjualans)
                  ->addIndexColumn()  // menambahkan kolom index / no urut (default name kolom: DT_RowIndex)  
                  ->addColumn('action', function ($penjualan) {  // menambahkan kolom action  
                      $btn  = '<a href="'.url('/penjualan/' . $penjualan->penjualan_id).'" class="btn btn-info btn-sm">Detail</a> '; 
                       $btn .= '<a href="'.url('/penjualan/' . $penjualan->penjualan_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';  
                  $btn .= '<form class="d-inline-block" method="POST" action="'. url('/penjualan/'.$penjualan->penjualan_id).'">'  
                          . csrf_field() . method_field('DELETE') .   
                          '<button type="submit" class="btn btn-danger btn-sm" onclick="return 
      confirm(\'Are u sure want to delete this data?\');">Delete</button></form>';
      return $btn;
      })
      ->rawColumns(['action']) // memberitahu bahwa kolom action adalah html  
      ->make(true);
      }
        //menampilkan detail user
    public function show(string $id)
    {
        $penjualan = Penjualanm::with('user')->find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Transaction',
            'list' => ['home', 'transaction', 'detail']
        ];

        $page = (object)[
            'title' => 'detail transaction'
        ];
        $activeMenu = 'penjualan';
        return view('penjualan.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'activeMenu' => $activeMenu]);
    }

}