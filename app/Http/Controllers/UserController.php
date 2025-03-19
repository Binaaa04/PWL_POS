<?php

namespace App\Http\Controllers;
use App\Models\Userm;
use App\Models\Levelm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

use function Laravel\Prompts\password;

class UserController extends Controller
{
    public function index(){
      $breadcrumb =(object)[
        'title'=>'User List',
        'list'=>['Home','User']
      ];
      $page=(object)[
        'title'=>'list of users registered in the system'
      ];
      $activeMenu = 'user'; //set menu yang sedang aktif
      return view('user.index',['breadcrumb'=>$breadcrumb,'page'=>$page,'activeMenu'=>$activeMenu]);
    }
    public function list(Request $request)
    {
        $users = Userm::select('user_id', 'username', 'nama', 'level_id')
                ->with('level');

        return DataTables::of($users)
            ->addIndexColumn() // Menambahkan index nomor urut
            ->addColumn('action', function ($user) { // Menambahkan kolom aksi
                $btn  = '<a href="'.url('/user/' . $user->user_id).'" class="btn btn-info btn-sm">Detail</a> ';
                $btn .= '<a href="'.url('/user/' . $user->user_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> ';
                $btn .= '<form class="d-inline-block" method="POST" action="'.url('/user/'.$user->user_id).'" style="display:inline;">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this data?\');">Delete</button>
                         </form>';
                return $btn;
            })
            ->rawColumns(['action']) // Menandai bahwa kolom action mengandung HTML
            ->make(true);
    }

    
    /*public function adding(){
        return view('user_add');
    }
    public function add_save(Request $request){
        Userm::create([
            'username'=>$request->username,
            'name'=>$request->name,
            'password'=>Hash::make($request->password),
            'level_id'=>$request->level_id
        ]);
        return redirect('/user');
    }
    public function edit($id){
        $user = Userm:: find($id);
        return view('user_edit',['data'=>$user]);
    }
    public function edit_save($id, Request $request){
        $user = Userm::find($id);
        $user->username = $request->username;
        $user->name = $request->name;
        $user->level_id = $request->level_id;
        $user -> save();
        return redirect('/user');

    }
    public function delete($id){
        $user = Userm::find($id);
        $user->delete();
        return redirect('/user');*/
    }
