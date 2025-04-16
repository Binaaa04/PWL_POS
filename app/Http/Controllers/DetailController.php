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
    public function show(string $id)
    {
        $detail = Detailm::with('barang', 'penjualan')->find($id);

        $breadcrumb = (object)[
            'title' => 'Detail Transaction',
            'list' => ['Home', 'Detail Transaction', 'Detail']
        ];

        $page = (object)[
            'title' => 'Detail Transaction'
        ];
        $activeMenu = 'detail';
        return view('detail.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'detail' => $detail, 'activeMenu' => $activeMenu]);
    }

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Add New Detail Transaction',
            'list' => ['Home', 'Detail Transaction', 'Add Data']
        ];
        $page = (object)[
            'title' => 'Add new Detail Transaction data'
        ];
        $penjualan = Penjualanm::all();
        $barang = Barangm::all(); //ambil data barang untuk ditampilkan di form
        $activeMenu = 'detail'; //set menu yang sedang aktif
        return view('detail.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'penjualan' => $penjualan,'activeMenu' => $activeMenu]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'harga' => 'required|integer',
            'jumlah' => 'required|integer',
            'barang_id' => 'required|integer',
            'penjualan_id' => 'required|integer'
        ]);

        Detailm::create([
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
            'barang_id' => $request->barang_id,
            'penjualan_id' => $request->penjualan_id
        ]);
        return redirect('/detail')->with('success', 'Detail Transaction data succesfully added');
    }

    public function edit($id)
    {
        $detail = Detailm::find($id);
        $barang = Barangm::all();
        $penjualan = Penjualanm::all();

        $breadcrumb = (object)[
            'title' => 'Detail Transaction Edit',
            'list' => ['Home', 'Detail Transaction', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Detail Transaction Data'
        ];
        $activeMenu = 'detail'; //set menu yang sedang aktif

        return view('detail.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'detail' => $detail, 'barang' => $barang, 'activeMenu' => $activeMenu, 'penjualan' => $penjualan]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'harga' => 'required|integer',
            'jumlah' => 'required|integer',
            'barang_id' => 'required|integer',
            'penjualan_id' => 'required|integer'
        ]);
        Detailm::find($id)->update([
            'harga' => $request->harga,
            'jumlah' => $request->jumlah,
            'barang_id' => $request->barang_id,
            'penjualan_id' => $request->penjualan_id
        ]);
        return redirect('/detail')->with('success', 'Successful change data');
    }

    public function destroy(string $id)
    {
        $check = Detailm::find($id);
        if (!$check) {
            return redirect('/detail')->with('error', 'Data not found');
        }
        try {
            Detailm::destroy($id);
            return redirect('/detail')->with('success', 'user data successful deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman dgn membaa pesan error
            return redirect('/detail')->with('error', 'user data failed deleted because there is another table connected with this data');
        }
    }

}