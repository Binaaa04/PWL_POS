<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barangm;


class ItemController extends Controller
{
    public function index(){
        return Barangm::all();
    }

    public function store(Request $request){
        $barang = Barangm::create($request->all());

        return response()->json($barang, 201);
    }

    public function show(Barangm $barang){
        return Barangm::find($barang);
    }

    public function update(Request $request, $barang_id)
    {
        $barang = Barangm::where('barang_id', $barang_id)->first();

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $barang->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data updated successfully',
            'data' => $barang
        ]);
    }

    public function updateByKode(Request $request, $barang_kode)
    {
        $barang = Barangm::where('barang_kode', $barang_kode)->first();

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $barang->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Data updated successfully',
            'data' => $barang
        ]);
    }


    public function destroy($barang_kode)
    {
        $barang = Barangm::where('barang_kode', $barang_kode)->first();

        if (!$barang) {
            return response()->json([
                'success' => false,
                'message' => 'Data not found'
            ], 404);
        }

        $barang->delete();

        return response()->json([
            'success' => true,
            'message' => 'Data deleted successfully'
        ]);
    }

}