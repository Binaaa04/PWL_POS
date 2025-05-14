<?php 
namespace App\Http\Controllers;

use App\Models\Barangm;
use App\Models\LevelModel; 
use App\Models\BarangModel;
use App\Models\Kategorim;
use App\Models\KategoriModel;
use App\Models\Levelm;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Hash; 
use Illuminate\Support\Facades\Validator; 
use PhpOffice\PhpSpreadsheet\IOFactory; 
use Yajra\DataTables\Facades\DataTables;
use Barryvdh\DomPDF\Facade\Pdf;

use function Termwind\render;

class BarangController extends Controller 
{ 
    
    public function index (){
        $activeMenu = 'barang'; 
        $breadcrumb = (object) [ 
            'title' => 'Data Barang', 
            'list' => ['Home', 'Barang'] 
        ]; 
 
        $kategori = Kategorim::select('kategori_id', 'kategori_nama')->get(); 
        return view('item.index', [ 
            'activeMenu' => $activeMenu, 
            'breadcrumb' => $breadcrumb, 
            'kategori' => $kategori 
        ]); 
    } 
 
    public function list(Request $request) 
    { 
        $barang = Barangm::select('barang_id', 'barang_kode', 'barang_nama', 
'harga_beli', 'harga_jual', 'kategori_id')->with('kategori'); 
 
        $kategori_id = $request->input('filter_kategori'); 
        if(!empty($kategori_id)){ 
            $barang->where('kategori_id', $kategori_id); 
        } 
 
        return DataTables::of($barang) 
            ->addIndexColumn() 
            ->addColumn('action', function ($barang) { // menambahkan kolom action 
                /*$btn = '<a href="'.url('/barang/' . $barang->barang_id).'" class="btn btn
info btn-sm">Detail</a> '; 
                $btn .= '<a href="'.url('/barang/' . $barang->barang_id . 
'/edit').'"class="btn btn-warning btn-sm">Edit</a> '; 
                $btn .= '<form class="d-inline-block" method="POST" action="'. 
                    url('/barang/'.$barang->barang_id).'">' 
                    . csrf_field() . method_field('DELETE') . 
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return 
confirm(\'Apakah Kita yakit menghapus data ini?\');">Hapus</button></form>';*/ 
                $btn = '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id 
. '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/barang/' . $barang->barang_id . '/delete_ajax').'\')" class="btn btn-danger btn-sm">Hapus</button> '; 
                return $btn; 
            }) 
            ->rawColumns(['action']) // ada teks html 
            ->make(true); 
    } 
 
    public function create_ajax() 
    { 
        $kategori = Kategorim::select('kategori_id', 'kategori_nama')->get(); 
        return  view('item.create_ajax')->with('kategori', $kategori); 
    } 
 
    public function store_ajax(Request $request) 
    { 
        if($request->ajax() || $request->wantsJson()){ 
            $rules = [ 
                'kategori_id' => ['required', 'integer', 'exists:m_kategori,kategori_id'], 
                'barang_kode' => ['required', 'min:3', 'max:20', 
'unique:m_barang,barang_kode'], 
                'barang_nama' => ['required', 'string', 'max:100'], 
                'harga_beli' => ['required', 'numeric'], 
                'harga_jual' => ['required', 'numeric'], 
            ]; 
 
            $validator = Validator::make($request->all(), $rules); 
            if($validator->fails()){ 
                return response()->json([ 
                    'status' => false, 
                    'message' => 'Validasi Gagal', 
                    'msgField' => $validator->errors() 
                ]); 
            } 
 
            Barangm::create($request->all()); 
            return response()->json([ 
                'status' => true, 
                'message' => 'Data berhasil disimpan' 
            ]); 
        } 
        redirect('/'); 
    } 
 
    public function edit_ajax($id) 
    { 
        $barang = Barangm::find($id); 
        $level = Levelm::select('level_id', 'level_nama')->get(); 
        return view('item.edit_ajax', ['barang' => $barang, 'level' => $level]); 
    } 
 
    public function update_ajax(Request $request, $id) 
    { 
        // cek apakah request dari ajax 
        if ($request->ajax() || $request->wantsJson()) { 
            $rules = [ 
                'kategori_id' => ['required', 'integer', 'exists:m_kategori,kategori_id'], 
                'barang_kode' => ['required', 'min:3', 'max:20', 
'unique:m_barang,barang_kode, '. $id .',barang_id'], 
                'barang_nama' => ['required', 'string', 'max:100'], 
                'harga_beli' => ['required', 'numeric'], 
                'harga_jual' => ['required', 'numeric'], 
            ]; 
 
            // use Illuminate\Support\Facades\Validator; 
            $validator = Validator::make($request->all(), $rules); 
            if ($validator->fails()) { 
                return response()->json([ 
                    'status' => false, // respon json, true: berhasil, false: gagal 
                    'message' => 'Validasi gagal.', 
                    'msgField' => $validator->errors() // menunjukkan field mana yang error 
                ]); 
            } 
 
            $check = Barangm::find($id); 
            if ($check) { 
                $check->update($request->all()); 
                return response()->json([ 
                    'status' => true, 
                    'message' => 'Data berhasil diupdate' 
                ]); 
            } else{ 
                return response()->json([ 
                    'status' => false, 
                    'message' => 'Data tidak ditemukan' 
                ]); 
            } 
        } 
        return redirect('/'); 
    } 
 
    public function confirm_ajax($id) 
    { 
        $barang = Barangm::find($id); 
        return view('item.confirm_ajax', ['barang' => $barang]); 
    } 
 
    public function delete_ajax(Request $request, $id) 
    { 
        if($request->ajax() || $request->wantsJson()){ 
            $barang = Barangm::find($id); 
            if($barang){ // jika sudah ditemuikan 
                $barang->delete(); // barang di hapus 
                return response()->json([ 
                    'status' => true, 
                    'message' => 'Data berhasil dihapus' 
                ]); 
            }else{ 
                return response()->json([ 
                    'status' => false, 
                    'message' => 'Data tidak ditemukan' 
                ]); 
            } 
        } 
        return redirect('/'); 
    } 
 
    public function import() 
    { 
        return view('item.import'); 
    } 
 
    public function import_ajax(Request $request) 
    { 
        if($request->ajax() || $request->wantsJson()){ 
            $rules = [ 
                // validasi file harus xls atau xlsx, max 1MB 
                'file_barang' => ['required', 'mimes:xlsx', 'max:1024'] 
            ]; 
 
            $validator = Validator::make($request->all(), $rules); 
            if($validator->fails()){ 
                return response()->json([ 
                    'status' => false, 
                    'message' => 'Validasi Gagal', 
                    'msgField' => $validator->errors() 
                ]); 
            } 
 
            $file = $request->file('file_barang');  // ambil file dari request 
 
            $reader = IOFactory::createReader('Xlsx');  // load reader file excel 
            $reader->setReadDataOnly(true);             // hanya membaca data 
            $spreadsheet = $reader->load($file->getRealPath()); // load file excel 
            $sheet = $spreadsheet->getActiveSheet();    // ambil sheet yang aktif 
 
            $data = $sheet->toArray(null, false, true, true);   // ambil data excel 
 
            $insert = []; 
            if(count($data) > 1){ // jika data lebih dari 1 baris 
                foreach ($data as $baris => $value) { 
                    if($baris > 1){ // baris ke 1 adalah header, maka lewati 
                        $insert[] = [ 
                            'kategori_id' => $value['A'], 
                            'barang_kode' => $value['B'], 
                            'barang_nama' => $value['C'], 
                            'harga_beli' => $value['D'], 
                            'harga_jual' => $value['E'], 
                            'created_at' => now(), 
                        ]; 
                    } 
                } 
 
                if(count($insert) > 0){ 
                    // insert data ke database, jika data sudah ada, maka diabaikan 
                    Barangm::insertOrIgnore($insert);    
                }
                                return response()->json([ 
                    'status' => true, 
                    'message' => 'Data berhasil diimport' 
                ]); 
            }else{ 
                return response()->json([ 
                    'status' => false, 
                    'message' => 'Tidak ada data yang diimport' 
                ]); 
            } 
        } 
        return redirect('/'); 
    } 
    public function export_excel(){
        $barang = Barangm::select('kategori_id','barang_kode','barang_nama','harga_beli','harga_jual')
        ->orderBy('kategori_id')
        ->with('kategori')
        ->get();
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet ->setCellValue('A1','No');
        $sheet ->setCellValue('B1','Item Code');
        $sheet ->setCellValue('C1','Item Name');
        $sheet ->setCellValue('D1','Selling Price');
        $sheet ->setCellValue('E1','Purchase Price');
        $sheet ->setCellValue('F1','Category Item');
        $sheet ->getStyle('A1:F1')->getFont()->setBold(true);

        $no = 1;
        $baris = 2;
        foreach ($barang as $key => $value) {
        $sheet ->setCellValue('A'.$baris,$no);
        $sheet ->setCellValue('B'.$baris,$value->barang_kode);
        $sheet ->setCellValue('C'.$baris,$value->barang_nama);
        $sheet ->setCellValue('D'.$baris,$value->harga_beli);
        $sheet ->setCellValue('E'.$baris,$value->harga_jual);
        $sheet ->setCellValue('F'.$baris,$value->kategori->kategori_nama);
        $baris++;
        $no++;
        }
         foreach (range('A','F') as $columnID) {
         $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        $sheet->setTitle('Data Barang');
        $writer = IOFactory::createWriter($spreadsheet,'Xlsx');
        $filename = 'Data Barang'.date('Y-m-d H:i:s').'.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="');
        header('Cache-control:max-age=0');
        header('Cache-control:max-age=1');
        header('Expires:  Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: '.gmdate('D,d M Y H:i:s').' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }
    public function export_pdf(){
        $barang = Barangm::select('kategori_id','barang_kode','barang_nama','harga_beli','harga_jual')
        ->orderBy('kategori_id')
        ->with('kategori')
        ->get();

        $pdf = Pdf::loadView('item.export_pdf',['barang'=>$barang]);
        $pdf ->setPaper('a4','potrait');
        $pdf -> setOption("isRemoteEnabled",true);
        $pdf -> render();
        return $pdf->stream('Data Barang'.date('Y-m-d H:i:s').'.pdf');
    }
}