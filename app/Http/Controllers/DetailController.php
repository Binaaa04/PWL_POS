<?php

namespace App\Http\Controllers;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;
use App\Models\Detailm;
use App\Models\Barangm;
use App\Models\Penjualanm;

class DetailController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Detail Transaction List',
            'list' => ['Home', 'Detail Transaction']
        ];
        $page = (object)[
            'title' => 'Detail Transaction list integreted in system'
        ];
        $activeMenu = 'detail'; //set menu yang sedang aktif

        $barang = Barangm::all(); //ambil data barang utk filter barang
        $penjualan = Penjualanm::all();

        return view('detail.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu, 'penjualan' => $penjualan]);
    }

    public function list(Request $request)
    {
         $detail = Detailm::select('detail_id', 'harga', 'jumlah','barang_id','penjualan_id')->with('barang', 'penjualan');
    
         return DataTables::of($detail)
             ->addIndexColumn()  // menambah/ `n kolom index / no urut (default name kolom: DT_RowIndex)  
             ->addColumn('action', function ($detail) {  // menambahkan kolom action  
                 $btn  = '<a href="'.url('/detail/' . $detail->detail_id).'" class="btn btn-info btn-sm">Detail</a> '; 
                  $btn .= '<a href="'.url('/detail/' . $detail->detail_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';  
             $btn .= '<form class="d-inline-block" method="POST" action="'. url('/detail/'.$detail->detail_id).'">'  
                     . csrf_field() . method_field('DELETE') .   
                     '<button type="submit" class="btn btn-danger btn-sm" onclick="return 
                        confirm(\'Are u sure want to delete this data?\');">Delete</button></form>';
                        return $btn;
                        })
                        ->rawColumns(['action']) // memberitahu bahwa kolom action adalah html  
                        ->make(true);
                        }

}