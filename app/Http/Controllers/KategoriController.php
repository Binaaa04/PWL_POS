<?php

namespace App\Http\Controllers;

use App\Models\Kategorim;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'Categories Data ',
            'list' => ['Home', 'Category']
        ];
        $page = (object)[
            'title' => 'Categories list integreted in system'
        ];
        $activeMenu = 'kategori'; //set menu yang sedang aktif

        $kategori = Kategorim::all();

        return view('category.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'kategori' => $kategori]);
    }

    public function list(Request $request)
    {
        $categories = Kategorim::select('kategori_id', 'kategori_kode', 'kategori_nama');

        // Filter data kategori berdasarkan kategori_id 
        if ($request->kategori_id) {
            $categories->where('kategori_id', $request->kategori_id);
        }

        return DataTables::of($categories)
            ->addIndexColumn()  // menambahkan kolom index / no urut (default name kolom: DT_RowIndex)  
            ->addColumn('action', function ($kategori) {  // menambahkan kolom action  
                $btn  = '<a href="' . url('/kategori/' . $kategori->kategori_id) . '" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="' . url('/kategori/' . $kategori->kategori_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="' . url('/kategori/' . $kategori->kategori_id) . '">'
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
            'title' => 'Add New Categories',
            'list' => ['home', 'Categories', 'Add']
        ];
        $page = (object)[
            'title' => 'Add new categories'
        ];
        $kategori = Kategorim::all(); //ambil data kategori untuk ditampilkan di form
        $activeMenu = 'kategori'; //set menu yang sedang aktif
        return view('category.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|min:3',
            'kategori_nama' => 'required|string|max:100',
        ]);

        Kategorim::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);
        return redirect('/kategori')->with('success', 'Category data succesfully changed');
    }
    public function show(string $id)
    {
        $kategori = Kategorim::find($id);

        $breadcrumb = (object)[
            'title' => 'detail Categories',
            'list' => ['Home', 'Categories', 'Detail']
        ];

        $page = (object)[
            'title' => 'detail Categories'
        ];
        $activeMenu = 'kategori';
        return view('category.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function edit($id)
        {
            $kategori = Kategorim::find($id);
    
            $breadcrumb = (object)[
                'title' => 'Categories Data ',
                'list' => ['Home', 'Categories', 'Edit']
            ];
            $page = (object)[
                'title' => 'Edit Categories Data'
            ];
            $activeMenu = 'kategori'; //set menu yang sedang aktif
    
            return view('category.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
        }

        public function update(Request $request, string $id)
    {
        $request->validate([ 
            'kategori_kode' => 'required|string|min:3',
            'kategori_nama' => 'required|string|max:100',
        ]);
        Kategorim::find($id)->update([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama,
        ]);
        return redirect('/kategori')->with('success', 'Successful change data');
    }
}
