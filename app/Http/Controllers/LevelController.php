<?php

namespace App\Http\Controllers;
use App\Models\Levelm;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index(){
      $breadcrumb = (object)[
        'title' => 'Level Data ',
        'list' => ['Home', 'Level']
    ];
    $page = (object)[
        'title' => 'level list integreted in system'
    ];
    $activeMenu = 'level'; //set menu yang sedang aktif

    return view('level.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function list(Request $request)
    {
        $levels = Levelm::select('level_id', 'level_kode', 'level_nama');

        return DataTables::of($levels)
            ->addIndexColumn()  // menambahkan kolom index / no urut (default name kolom: DT_RowIndex)  
            ->addColumn('action', function ($level) {  // menambahkan kolom action  
                $btn  = '<a href="'.url('/level/' . $level->level_id).'" class="btn btn-info btn-sm">Detail</a> '; 
                 $btn .= '<a href="'.url('/level/' . $level->level_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';  
            $btn .= '<form class="d-inline-block" method="POST" action="'. url('/level/'.$level->level_id).'">'  
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
            'title' => 'Add New Level',
            'list' => ['home', 'level', 'Add Level']
        ];
        $page = (object)[
            'title' => 'Add new level data'
        ];
        $activeMenu = 'level'; //set menu yang sedang aktif
        return view('level.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }
    public function store(Request $request)
    {
        $request->validate([
            //username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
            'level_kode' => 'required|string|min:3',
            'level_nama' => 'required|string|max:100',
        ]);

        Levelm::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);
        return redirect('/level')->with('success', 'level data succesfully changed');
    }
}
