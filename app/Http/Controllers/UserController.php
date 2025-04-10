<?php

namespace App\Http\Controllers;

use App\Models\Userm;
use App\Models\Levelm;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;


class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object)[
            'title' => 'User ',
            'list' => ['Home', 'User']
        ];
        $page = (object)[
            'title' => 'user list integreted in system'
        ];
        $activeMenu = 'user'; //set menu yang sedang aktif

        $level = Levelm::all(); //ambil data level utk filter level

        return view('user.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }
    public function create()
    {
        $breadcrumb = (object)[
            'title' => 'Add New User',
            'list' => ['home', 'user', 'tambah']
        ];
        $page = (object)[
            'title' => 'tambah user baru'
        ];
        $level = Levelm::all(); //ambil data level untuk ditampilkan di form
        $activeMenu = 'user'; //set menu yang sedang aktif
        return view('user.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax()
    {
        $level = Levelm::select('level_id', 'level_nama')->get();
        return view('user.create_ajax')->with('level', $level);
    }

    public function store(Request $request)
    {
        $request->validate([
            //username harus diisi, berupa string, minimal 3 karakter, dan bernilai unik di tabel m_user kolom username
            'username' => 'required|string|min:3|unique:m_user,username',
            'name' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ]);

        Userm::create([
            'username' => $request->username,
            'name' => $request->name,
            'password' => bcrypt($request->password), //password dienskripsi sebelum disimpan
            'level_id' => $request->level_id
        ]);
        return redirect('/user')->with('success', 'user data succesfully changed');
    }

    public function store_ajax(Request $request)
    {
        //cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'name' => 'required|string|max:100',
                'password' => 'required|min:6'
            ];

            //illuminate\support\facades\validator;
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'validation not successful',
                    'msgField' => $validator->errors(), //pesan error validasi
                ]);
            }
            Userm::create($request->all());
            return response()->json([
                'status' => true,
                'message' => 'data success saved'
            ]);
        }
        redirect('/');
    }

    //menampilkan detail user
    public function show(string $id)
    {
        $user = Userm::with('level')->find($id);

        $breadcrumb = (object)[
            'title' => 'detail user',
            'list' => ['home', 'user', 'detail']
        ];

        $page = (object)[
            'title' => 'detail user'
        ];
        $activeMenu = 'user';
        return view('user.show', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'activeMenu' => $activeMenu]);
    }

    // Ambil data user dalam bentuk json untuk datatables  
    public function list(Request $request)
    {
        $users = Userm::select('user_id', 'username', 'name', 'level_id')
            ->with('level');

        // Filter data user berdasarkan level_id 
        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            ->addIndexColumn()  // menambahkan kolom index / no urut (default name kolom: DT_RowIndex)  
            ->addColumn('action', function ($user) {  // menambahkan kolom action  
                /* $btn  = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn
sm">Detail</a> '; 
                 $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn
warning btn-sm">Edit</a> ';  
            $btn .= '<form class="d-inline-block" method="POST" action="'. url('/user/'.$user
>user_id).'">'  
                    . csrf_field() . method_field('DELETE') .   
                    '<button type="submit" class="btn btn-danger btn-sm" onclick="return 
confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';*/
                $btn  = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/show') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/delete_ajax') . '\')"  class="btn btn-danger btn-sm">Delete</button> ';

                return $btn;
            })
            ->rawColumns(['action']) // memberitahu bahwa kolom action adalah html  
            ->make(true);
    }


    public function adding()
    {
        return view('user_add');
    }
    public function add_save(Request $request)
    {
        Userm::create([
            'username' => $request->username,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'level_id' => $request->level_id
        ]);
        return redirect('/user');
    }
    public function edit($id)
    {
        $user = Userm::find($id);
        $level = Levelm::all();

        $breadcrumb = (object)[
            'title' => 'User ',
            'list' => ['Home', 'User', 'Edit']
        ];
        $page = (object)[
            'title' => 'Edit User'
        ];
        $activeMenu = 'user'; //set menu yang sedang aktif

        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function edit_ajax(string $id){
        $user = Userm::find($id);
        $level = Levelm::select('level_id','level_nama')->get();
        return view('user.edit_ajax',['user'=>$user, 'level'=>$level]);
    }
    public function update(Request $request, string $id)
    {
        $request->validate([
            //username hrs diisi, berupa string, min 3 karakter, 
            //dan bernilai unik di tabel m_user kolom username kecuali utk user dgn id yg sedang diedit 
            'username' => 'required|string|min:3|unique:m_user,username,' . $id . ',user_id',
            'name' => 'required|string|max:100',
            'password' => 'nullable|min:5',
            'level_id' => 'required|integer'
        ]);
        Userm::find($id)->update([
            'username' => $request->username,
            'name' => $request->name,
            'password' => $request->password ? bcrypt($request->password) : Userm::find($id)->password,
            'level_id' => $request->level_id
        ]);
        return redirect('/user')->with('success', 'Successful change data');
    }

    public function update_ajax(Request $request, $id){
        // cek apakah request dari ajax 
    if ($request->ajax() || $request->wantsJson()) { 
        $rules = [ 
            'level_id' => 'required|integer', 
            'username' => 'required|max:20|unique:m_user,username,'.$id.',user_id', 
            'name'     => 'required|max:100', 
            'password' => 'nullable|min:6|max:20' 
        ]; 
         
        // use Illuminate\Support\Facades\Validator; 
        $validator = Validator::make($request->all(), $rules); 
 
        if ($validator->fails()) { 
            return response()->json([ 
                'status'   => false,    // respon json, true: berhasil, false: gagal 
                'message'  => 'Validasi gagal.', 
                'msgField' => $validator->errors()  // menunjukkan field mana yang error 
            ]); 
        } 
 
        $check = Userm::find($id); 
        if ($check) { 
            if(!$request->filled('password') ){ // jika password tidak diisi, maka hapus dari request 
                $request->request->remove('password'); 
            } 
             
            $check->update($request->all()); 
            return response()->json([ 
                'status'  => true, 
                'message' => 'Data successfully changed' 
            ]); 
        } else{ 
            return response()->json([ 
                'status'  => false, 
                'message' => 'Data not found' 
            ]); 
        } 
    } 
    return redirect('/'); 
}
    public function destroy(string $id)
    {
        $check = Userm::find($id);
        if (!$check) {
            return redirect('/user')->with('error', 'Data not found');
        }
        try {
            Userm::destroy($id);
            return redirect('/user')->with('success', 'user data successful deleted');
        } catch (\Illuminate\Database\QueryException $e) {
            //jika terjadi error ketika menghapus data, redirect kembali ke halaman dgn membaa pesan error
            return redirect('/user')->with('error', 'user data failed deleted because there is another table connected with this data');
        }
    }

    public function edit_save($id, Request $request)
    {
        $user = Userm::find($id);
        $user->username = $request->username;
        $user->name = $request->name;
        $user->level_id = $request->level_id;
        $user->save();
        return redirect('/user');
    }
    public function delete($id)
    {
        $user = Userm::find($id);
        $user->delete();
        return redirect('/user');
    }

    public function confirm_ajax(string $id){
        $user = Userm::find($id);
        return view('user.confirm_ajax',['user'=>$user]);
    }

    public function delete_ajax(Request $request, $id){
        if ($request->ajax()||$request->wantsJson()) {
            $user = Userm::find($id);
            if ($user) {
                $user->delete();
                return response()->json([
                    'status'=>true,
                    'message'=>'data successfully deleted'
                ]);
            } else {
                return response()->json([
                    'status'=>false,
                    'message'=>'data not found'
                ]);
            }  
        }
        return redirect('/');
    }
}
