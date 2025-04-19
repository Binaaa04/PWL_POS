<?php

namespace App\Http\Controllers;

use App\Models\Barangm;
use App\Models\Kategorim;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BarangController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'Item List',
            'list' => ['Home', 'Item']
        ];
        $page = (object) [
            'title' => 'Item List Integreted with system'
        ];
        $kategori = Kategorim::all();
        $activeMenu = 'barang'; // set menu yang sedang aktif
        return view('item.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Add Data',
            'list' => [
                'Home',
                'Item',
                'Add Data'
            ]
        ];
        $page = (object) [
            'title' => 'Add new item data'
        ];
        $kategori = Kategorim::all();
        $activeMenu = 'barang'; // set menu yang sedang aktif
        return view('item.create', ['breadcrumb' => $breadcrumb, 'page' => $page,'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax()
    {
        $kategori = Kategorim::all();
        return view('item.create_ajax', ['kategori' => $kategori]);
    }

    public function store_ajax(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|integer',
            'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|min:3|unique:m_barang,barang_nama',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer'
        ]);

        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => 'required|integer',
                'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
                'barang_nama' => 'required|string|min:3|unique:m_barang,barang_nama',
                'harga_beli' => 'required|integer',
                'harga_jual' => 'required|integer'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed validation',
                    'msgField' => $validator->errors()
                ]);
            }
            Barangm::create([
                'kategori_id' => $request->kategori_id,
                'barang_kode' => $request->barang_kode,
                'barang_nama' => $request->barang_nama,
                'harga_beli' => $request->harga_beli,
                'harga_jual' => $request->harga_jual
            ]);
            return response()->json([
                'status' => true,
                'message' => 'item data succesfully saved'
            ]);
        }
        redirect('/');
    }
    // Menyimpan data barang baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|integer',
            'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|min:3|unique:m_barang,barang_nama',
            'harga_beli' => 'required|integer',
            'harga_jual' => 'required|integer'
        ]);
        Barangm::create([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual
        ]);
        return redirect('/barang')->with('success', 'item data succesfully saved');
    }

    public function list(Request $request)
    {
        $barangs = Barangm::select('barang_id', 'kategori_id', 'barang_nama', 'barang_kode', 'harga_beli', 'harga_jual')->with('kategori');

        return DataTables::of($barangs)
            // menambahkan kolom index / no urut (default nama kolom: DT_RowIndex) 
            ->addIndexColumn()
            ->addColumn('action', function ($barang) {  // menambahkan kolom action 
                $btn  = '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .
                    '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Delete</button> ';
                return $btn;
            })
            ->rawColumns(['action']) // memberitahu bahwa kolom action adalah html 
            ->make(true);
    }

    // Menampilkan detail barang
    public function show(string $id)
    {
        $barang = Barangm::find($id);
        $breadcrumb = (object) [
            'title' => 'Detail Item',
            'list' => ['Home', 'Item', 'Detail']
        ];
        $page =
            (object) [
                'title' => 'Detail Item'
            ];
        $activeMenu = 'barang'; // set menu yang sedang aktif
        return view('item.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'activeMenu' => $activeMenu]);
    }

    public function show_ajax(string $id)
{
    $barang = Barangm::with('kategori')->find($id); // pastikan relasi 'kategori' didefinisikan
    return view('item.show_ajax', ['barang' => $barang]);
}


    // Menampilkan halaman form edit barang
    public function edit(string $id)
    {
        $barang = Barangm::find($id);
        $breadcrumb = (object) [
            'title' => 'Edit Item',
            'list' => ['Home', 'Item', 'Edit']
        ];
        $page = (object) [
            'title' => 'Edit Item'
        ];
        $kategori = Kategorim::all();
        $activeMenu = 'barang'; // set menu yang sedang aktif
        // Menyimpan perubahan data barang
        return view('item.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'barang' => $barang, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_id' => 'required|integer',
            'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'required|string|max:100',
            'harga_jual' => 'required|integer',
            'harga_beli' => 'required|integer'
        ]);

        Barangm::find($id)->update([
            // level_id harus diisi dan berupa angka
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_jual' => $request->harga_jual,
            'harga_beli' => $request->harga_beli
        ]);
        return redirect('/barang')->with('success', 'item data succesfully changed');
    }

    public function edit_ajax(string $id)
    {
        $barang = Barangm::find($id);
        $kategori = Kategorim::select('kategori_id', 'kategori_nama')->get();
        return view('item.edit_ajax', ['barang' => $barang, 'kategori' => $kategori]);
    }

    public function update_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax 
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => 'required|integer',
                'barang_kode' => 'required|string|min:3|unique:m_barang,barang_kode,' . $id . ',barang_id',
                'barang_nama' => 'required|string|max:100',
                'harga_jual' => 'required|integer',
                'harga_beli' => 'required|integer'
            ];

            // use Illuminate\Support\Facades\Validator; 
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,    // respon json, true: berhasil, false: gagal 
                    'message'  => 'Failed validation.',
                    'msgField' => $validator->errors()  // menunjukkan field mana yang error 
                ]);
            }
            $check = Barangm::find($id);
            if ($check) {
                if (!$request->filled('barang_kode')) { // jika password tidak diisi, maka hapus dari request 
                    $request->request->remove('barang_kode');
                }
                $check->update($request->all());
                return response()->json([
                    'status'  => true,
                    'message' => 'item data succesfully updated'
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

    // Menghapus data barang
    public function destroy(string $id)
    {
        $check = Barangm::find($id);
        if (!$check) {
            // untuk mengecek apakah data barang dengan id yang dimaksud ada atau tidak
            return redirect('/barang')->with('error', 'Item data not found');
        }
        try {
            Barangm::destroy($id);
            // Hapus data level
            return redirect('/barang')->with('success', 'item data succesfully deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/barang')->with('error', 'Item data failed to deleted because still connected with another table');
        }
    }

    public function confirm_ajax(string $id)
    {
        $barang = Barangm::find($id);
        return view('item.confirm_ajax', ['barang' => $barang]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if($request->ajax() || $request->wantsJson()){
            $barang = Barangm::find($id);
            if($barang){
                try {
                    Barangm::destroy($id);
                    return response()->json([
                        'status'  => true,
                        'message' => 'item data succesfully deleted'
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json([
                        'status'  => false,
                        'message' => 'Item data failed to deleted because still connected with another table'
                    ]);
                }
            }else{
                return response()->json([
                    'status'  => false,
                    'message' => 'Data not found'
                ]);
            }
    }
        redirect('/');
    }
}