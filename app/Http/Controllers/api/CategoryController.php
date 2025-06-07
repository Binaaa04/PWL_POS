<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategorim;


class CategoryController extends Controller
{
    public function index(){
        return Kategorim::all();
    }

    public function store(Request $request){
        $kategori = Kategorim::create($request->all());

        return response()->json($kategori, 201);
    }

    public function show(Kategorim $kategori){
        return Kategorim::find($kategori);
    }

    public function update(Request $request, $kategori_id)
    {
        $kategori = Kategorim::where('kategori_id', $kategori_id)->first();

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $kategori->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data updated successfully',
            'data' => $kategori
        ]);
    }

    public function updateByKode(Request $request, $kategori_kode)
    {
        $kategori = Kategorim::where('kategori_kode', $kategori_kode)->first();

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $kategori->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data updated successfully',
            'data' => $kategori
        ]);
    }


    public function destroy($kategori_kode)
    {
        $kategori = Kategorim::where('kategori_kode', $kategori_kode)->first();

        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $kategori->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data deleted successfully'
        ]);
    }

}