<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Userm;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use App\Models\Levelm;

class UserController extends Controller
{
    public function index()
    {
        $breadcrumb = (object) [
            'title' => 'User List',
            'list' => ['Home', 'User']
        ];

        $page = (object) [
            'title' => 'User list integreted in system'
        ];

        $activeMenu = 'user';

        $level = Levelm::all();

        return view('user.index', compact('breadcrumb', 'page', 'level', 'activeMenu'));
    }

    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $users = Userm::select('user_id', 'username', 'name', 'level_id')->with('level');

        if ($request->level_id) {
            $users->where('level_id', $request->level_id);
        }

        return DataTables::of($users)
            // menambahkan kolom index / no urut (default name kolom: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('action', function ($user) { // menambahkan kolom action
                // $btn = '<a href="' . url('/user/' . $user->user_id) . '" class="btn btn-info btn-
                // sm">Detail</a> ';
                // $btn .= '<a href="' . url('/user/' . $user->user_id . '/edit') . '" class="btn btn-
                // warning btn-sm">Edit</a> ';
                // $btn .= '<form class="d-inline-block" method="POST" action="' . url('/user/' . $user->user_id) . '">'
                //     . csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return
                // confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                $btn = '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/user/' . $user->user_id .
                    '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['action']) // memberitahu bahwa kolom aksi adalah html
            ->make(true);
    }

    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah User',
            'list' => ['Home', 'User', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah User Baru'
        ];

        $level = Levelm::all();
        $activeMenu = 'user';

        return view('user.create', compact('breadcrumb', 'page', 'level', 'activeMenu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|min:3| unique:m_user,username',
            'name' => 'required|string|max:100',
            'password' => 'required|min:5',
            'level_id' => 'required|integer'
        ]);
        Userm::create([
            'username' => $request->username,
            'name' => $request->name,
            'password' => bcrypt($request->password),
            'level_id' => $request->level_id
        ]);
        return redirect('/user')->with('success', 'Data user data saved successfully disimpan');
    }

    public function show(string $id)
    {
        $user = Userm::with('level')->find($id);
        $breadcrumb = (object) [
            'title' => 'Detail User',
            'list' => ['Home', 'User', 'Detail']
        ];
        $page = (object) [
            'title' => 'Detail user'
        ];
        $activeMenu = 'user'; // set menu yang sedang aktif
        return view('user.show', compact('breadcrumb', 'page', 'user', 'activeMenu'));
    }

    public function edit(string $id)
    {
        $user = Userm::find($id);
        $level = Levelm::all();

        $breadcrumb = (object) [
            'title' => 'Edit User',
            'list' => ['Home', 'User', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit user',
        ];
        $activeMenu = 'user';
        return view('user.edit', ['breadcrumb' => $breadcrumb, 'page' => $page, 'user' => $user, 'level' => $level, 'activeMenu' => $activeMenu]);
    }

    public function update(Request $request, string $id)
    {
        $request->validate([


            'username' => 'required|string |min: 3 unique:m_user, username, ' . $id . ', user_id',
            'name' => 'required string | max: 100',
            'password' => 'nullable |min:5',
            'level_id' => 'required|integer'
        ]);

        Userm::find($id)->update([
            'username' => $request->username,
            'name' => $request->name,
            'password' => $request->password ? bcrypt($request->password) : Userm::find($id)->password,
            'level_id' => $request->level_id
        ]);
        return redirect('/user')->with('success', 'Data user data user successfully updated diubah');
    }

    // Menghapus data user
    public function destroy(string $id)
    {
        $check = Userm::find($id);
        // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
        if (!$check) {
            return redirect('/user')->with('error', 'Data user tidak ditemukan');
        }
        try {
            Userm::destroy($id);
            // Hapus data level
            return redirect('/user')->with('success', 'Data user data user successfully deleted dihapus');
        } catch (\Illuminate\Database\QueryException $e) {
            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/user')->with('error', 'Data user gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }

    public function create_ajax()
    {
        $level = Levelm::select('level_id', 'level_nama')->get();
        return view('user.create_ajax', compact('level'));
    }

    public function store_ajax(Request $request)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|string|min:3|unique:m_user,username',
                'name' => 'required|string|max:100',
                'password' => 'required|min:6'
            ];
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Failed Validation',
                    'msgField' => $validator->errors(),
                ]);
            }
            Userm::create([
                'username' => $request->username,
                'name' => $request->name,
                'password' => bcrypt($request->password),
                'level_id' => $request->level_id
            ]);
            return response()->json([
                'status' => true,
                'message' => 'data saved successfully'
            ]);
        }
        return redirect('/');
    }

    public function show_ajax(string $id)
    {
        $user = Userm::find($id);
        $level = Levelm::select('level_id', 'level_nama')->get();

        return view('user.show_ajax', compact('user', 'level'));
    }

    public function edit_ajax(string $id)
    {
        $user = Userm::find($id);
        $level = Levelm::select('level_id', 'level_nama')->get();

        return view('user.edit_ajax', ['user' => $user, 'level' => $level]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'level_id' => 'required|integer',
                'username' => 'required|max:20|unique:m_user,username,' . $id . ',user_id',
                'name' => 'required|max:100',
                'password' => 'nullable|min:6|max:20'
            ];
            // use Illuminate\Support\Facades\Validator;
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // respon json, true: berhasil, false: gagal
                    'message' => 'Failed Validation',
                    'msgField' => $validator->errors() // menunjukkan field mana yang error
                ]);
            }
            $check = Userm::find($id);
            if ($check) {
                if (!$request->filled('password')) { // jika password tidak diisi, maka hapus dari request
                    $request->request->remove('password');
                }
                $check->update($request->all());
                return response()->json([
                    'status' => true,
                    'message' => 'data updated successfully'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found'
                ]);
            }
        }
        return redirect('/');
    }
    public function confirm_ajax(string $id)
    {
        $user = Userm::find($id);

        return view('user.confirm_ajax', ['user' => $user]);
    }

    public function delete_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $user = Userm::find($id);
            if ($user) {
                try {
                    $user->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'data deleted successfully'
                    ]);
                } catch (\Illuminate\Database\QueryException $e) {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data failed to delete! There are other tables associated with this data'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Data not found'
                ]);
            }
        }
        return redirect('/user');
    }
    public function profile()
    {
        $user = auth()->user();
        $breadcrumb = (object) [
            'title' => 'Profile',
            'list' => ['Home', 'Profile']
        ];

        $page = (object) [
            'title' => 'User Profile'
        ];

        $activeMenu = 'profile';
        return view('profile', compact('breadcrumb', 'page', 'user', 'activeMenu'));
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $authUser = auth()->user();
        $user = Userm::find($authUser->user_id);

        if ($user->image && file_exists(public_path($user->image))) {
            unlink(public_path($user->image));
        }

        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = 'uploads/profile/';

        if (!file_exists(public_path($filePath))) {
            mkdir(public_path($filePath), 0777, true);
        }

        $file->move(public_path($filePath), $fileName);

        $user->image = $filePath . $fileName;
        $user->save();

        return response()->json([
            'status' => true,
            'message' => 'Profile picture updated successfully',
            'image_url' => $user->getProfilePictureUrl()
        ]);
    }
}