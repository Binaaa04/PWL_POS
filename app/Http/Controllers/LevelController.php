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
            'level_kode' => 'required|string|min:3',
            'level_nama' => 'required|string|max:100',
        ]);

        Levelm::create([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);
        return redirect('/level')->with('success', 'level data succesfully changed');
    }

        //menampilkan detail level
        public function show(string $id)
        {
            $level = Levelm::find($id);
    
            $breadcrumb = (object)[
                'title' => 'detail level',
                'list' => ['home', 'level', 'detail']
            ];
    
            $page = (object)[
                'title' => 'detail level'
            ];
            $activeMenu = 'level';
            return view('level.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
        }

        public function edit($id)
        {
            $level = Levelm::find($id);
    
            $breadcrumb = (object)[
                'title' => 'Level Data ',
                'list' => ['Home', 'Level', 'Edit']
            ];
            $page = (object)[
                'title' => 'Edit Level Data'
            ];
            $activeMenu = 'level'; //set menu yang sedang aktif
    
            return view('level.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
        }

        public function update(Request $request, string $id)
    {
        $request->validate([ 
            'level_kode' => 'required|string|min:3',
            'level_nama' => 'required|string|max:100',
        ]);
        Levelm::find($id)->update([
            'level_kode' => $request->level_kode,
            'level_nama' => $request->level_nama,
        ]);
        return redirect('/level')->with('success', 'Successful change data');
    }

    public function destroy(string $id)
    {
        $check = Levelm::find($id);
        if (!$check) {
            return redirect('/level')->with('error', 'Data not found');
        }
        try {
            Levelm::destroy($id);
            return redirect('/level')->with('success', 'level data successful deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman dgn membaa pesan error
            return redirect('/level')->with('error', 'level data failed deleted because there is another table connected with this data');
        }
    }
}
