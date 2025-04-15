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

        //menampilkan detail transaction
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

    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Add New Transaction',
            'list' => ['Home', 'Transaction', 'Add Data']
        ];
        $page = (object)[
            'title' => 'Add new transaction data'
        ];
        $user = Userm::all(); //ambil data User untuk ditampilkan di form
        $activeMenu = 'penjualan'; //set menu yang sedang aktif
        return view('penjualan.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'pembeli' => 'required|string|max:10',
            'penjualan_kode' => 'required|string|max:10',
            'penjualan_tanggal' => 'required|date',
            'user_id' => 'required|integer'
        ]);

        Penjualanm::create([
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal,
            'user_id' => $request->user_id
        ]);
        return redirect('/penjualan')->with('success', 'transaction data succesfully added');
    }
    public function edit($id)
    {
        $penjualan = Penjualanm::find($id);
        $user = Userm::all();

        $breadcrumb = (object)[
            'title' => 'Edit Penjualan ',
            'list' => ['Home', 'Penjualan', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit Penjualan'
        ];
        $activeMenu = 'penjualan'; //set menu yang sedang aktif

        return view('penjualan.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'penjualan' => $penjualan, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'pembeli' => 'required|string|min:10|unique:t_penjualan,pembeli,' . $id . ',penjualan_id',
            'penjualan_kode' => 'required|string|max:20',
            'penjualan_tanggal' => 'required|date',
            'user_id' => 'required|integer'
        ]);
        Penjualanm::find($id)->update([
            'pembeli' => $request->pembeli,
            'penjualan_kode' => $request->penjualan_kode,
            'penjualan_tanggal' => $request->penjualan_tanggal,
            'user_id' => $request->user_id
        ]);
        return redirect('/penjualan')->with('success', 'Successful change data');
    }
    public function destroy(string $id)
    {
        $check = Penjualanm::find($id);
        if (!$check) {
            return redirect('/penjualan')->with('error', 'Data not found');
        }
        try {
            penjualanm::destroy($id);
            return redirect('/penjualan')->with('success', 'transaction data successful deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman dgn membaa pesan error
            return redirect('/penjualan')->with('error', 'transaction data failed deleted because there is another table connected with this data');
        }
    }

}