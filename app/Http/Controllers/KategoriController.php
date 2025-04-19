<?php

namespace App\Http\Controllers;

use App\Models\Kategorim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class KategoriController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Categories List',
            'list' => ['Home', 'Categories']
        ];
        $page = (object) [
            'title' => 'Category list integreted in system'
        ];
        $activeMenu = 'kategori'; // set menu yang sedang aktif
        return view('kategori.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Add Category',
            'list' => [
                'Home',
                'Categories',
                'Tambah'
            ]
        ];
        $page = (object) [
            'title' => 'Add new category data'
        ];
        $activeMenu = 'kategori'; // set menu yang sedang aktif
        return view('kategori.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax()
    {
        return view('kategori.create_ajax');
    }

    public function store_ajax(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max: 100'
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
                'kategori_nama' => 'required|string|max: 100',
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed validation',
                    'msgField' => $validator->errors()
                ]);
            }
            Kategorim::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'Category data successfully saved'
            ]);
        }
        redirect('/');
    }

    // Menyimpan data kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max: 100',
        ]);
        Kategorim::create([
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);
        return redirect('/kategori')->with('success', 'Data Successful saved');
    }

    public function list(Request $request)
    {
        $kategoris = Kategorim::select('kategori_id', 'kategori_kode', 'kategori_nama');

        return DataTables::of($kategoris)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addIndexColumn()
            ->addColumn('action', function ($kategori) {  // menambahkan kolom action 
                $btn  = '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/kategori/' . $kategori->kategori_id .
                    '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Delete</button> ';
                return $btn;
            })
            ->rawColumns(['action']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true);
    }

    // Menampilkan detail kategori
    public function show(string $id)
    {
        $kategori = Kategorim::find($id);
        $breadcrumb = (object) [
            'title' => 'Category Detail',
            'list' => ['Home', 'Category', 'Detail']
        ];
        $page =
            (object) [
                'title' => 'Category Detail'
            ];
        $activeMenu = 'kategori'; // set menu yang sedang aktif
        return view('kategori.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function show_ajax(string $id)
{
    $kategori = Kategorim::find($id);
    return view('kategori.show_ajax', ['kategori' => $kategori]);
}


    // Menampilkan halaman form edit kategori
    public function edit(string $id)
    {
        $kategori = Kategorim::find($id);
        $breadcrumb = (object) [
            'title' => 'Edit Category',
            'list' => ['Home', 'Category', 'Edit']
        ];
        $page = (object) [
            'title' => 'Edit Category'
        ];
        $activeMenu = 'kategori'; // set menu yang sedang aktif
        // Menyimpan perubahan data kategori
        return view('kategori.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            // kategoriname harus diisi, berupa string, minimal 3 karakter,
            // dan bernilai unik di tabel m_kategori kolom kategoriname kecuali untuk kategori dengan id yang sedang diedit
            'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode',
            'kategori_nama' => 'required|string|max: 100',
        ]);

        Kategorim::find($id)->update([
            // kategori_id harus diisi dan berupa angka
            'kategori_kode' => $request->kategori_kode,
            'kategori_nama' => $request->kategori_nama
        ]);
        return redirect('/kategori')->with('success', 'Data Successful changed');
    }

    public function edit_ajax(string $id)
    {
        $kategori = Kategorim::find($id);
        return view('kategori.edit_ajax', ['kategori' => $kategori]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax 
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_kode' => 'required|string|min:3|unique:m_kategori,kategori_kode,' . $id . ',kategori_id',
                'kategori_nama' => 'required|string|max: 100',
            ];

            // use Illuminate\Support\Facades\Validator; 
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,    // respon json, true: berhasil, false: gagal 
                    'message'  => 'failed validation.',
                    'msgField' => $validator->errors()  // menunjukkan field mana yang error 
                ]);
            }
            $check = Kategorim::find($id);
            if ($check) {
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request 
                    $request->request->remove('password');
                }
                $check->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => 'Data succesful changed'
                ]);
            } else {
                return response()->json([
                    'status'  => false,
                    'message' => 'Data not found'
                ]);
            }
        }
        redirect('/');
    }

    // Menghapus data kategori
    public function destroy(string $id)
    {
        $check = Kategorim::find($id);
        if (!$check) {
            // untuk mengecek apakah data kategori dengan id yang dimaksud ada atau tidak
            return redirect('/kategori')->with('error', 'Category Data is not found');
        }
        try {
            Kategorim::destroy($id);
            // Hapus data kategori
            return redirect('/kategori')->with('success', 'Category data successful deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/kategori')->with('error', 'Category data cannot deleted because the table connected with another table');
        }
    }
    public function confirm_ajax(string $id)
    {
        $kategori = Kategorim::find($id);
        return view('kategori.confirm_ajax', ['kategori' => $kategori]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if($request->ajax() || $request->wantsJson()){
            $kategori = Kategorim::find($id);
            if($kategori){
                try {
                    Kategorim::destroy($id);
                    return response()->json([
                        'status'  => true,
                        'message' => 'Data successful deleted'
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json([
                        'status'  => false,
                        'message' => 'Category data cannot deleted because the table connected with another table'
                    ]);
                }
            }else{
                return response()->json([
                    'status'  => false,
                    'message' => 'Data is not found'
                ]);
            }
    }
        redirect('/');
    }
}