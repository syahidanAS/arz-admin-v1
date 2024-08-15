<?php

namespace App\Http\Controllers;

use App\Helpers\Main;
use App\Http\Requests\UserRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Show Manajemen User', ['only' => ['index']]);
        $this->middleware('permission:Edit User', ['only' => ['edit']]);
        $this->middleware('permission:Delete User', ['only' => ['destroy']]);
        $this->middleware('permission:Store User', ['only' => ['store']]);
        $this->middleware('permission:Update User', ['only' => ['update']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = User::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('email', function ($row) {
                    return $row->email;
                })
                ->addColumn('email_verified_at', function ($row) {
                    if ($row->email_verified_at) {
                        $span = '<span class="badge badge-success bg-success">Sudah Verifikasi</span>';
                    } else {
                        $span = '<span class="badge badge-danger bg-danger">Belum Verifikasi</span>';
                    }
                    return $span;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex gap-2">';
                    $btn .= "<a href='javascript:void(0)' class='btn btn-warning btn-sm' type='button' id='btnEditUser' data-id='" . Main::hashIdsEncode($row->id) . "'>Ubah</a>";
                    $btn .= "<a href='javascript:void(0)' class='btn btn-danger btn-sm delete-item' data-id='" . Main::hashIdsEncode($row->id) . "' data-name='" . $row->name . "'>Hapus</a>";
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action', 'email_verified_at'])
                ->make(true);
        }
        return view('pages.settings.users.index');
    }

    public function getRoles(Request $request)
    {
        $query = $request->get('q');
        $roles = Role::where('name', 'like', "%$query%")->get();
        return $roles;
    }

    public function store(UserRequest $request)
    {
        try {
            $query = new User();
            $query->name = $request->name;
            $query->email = $request->email;
            $query->nik = $request->nik;
            $query->password = bcrypt($request->password);
            $query->email_verified_at = now();
            $query->save();
            $query->assignRole($request->role);
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menambahkan data',
                'data' => $request->all()
            ], 201);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan data karena terjadi kesalahan!',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $user = User::findOrFail(Main::hashIdsDecode($id));
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mendapatkan data',
                'data' => $user,
                'role' => $user->roles[0]->name ?? null
            ], 200);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mendapatkan data karena terjadi kesalahan!',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function update(Request $request)
    {
        try {
            $query = User::find($request->id);
            $query->name = $request->name;
            $query->email = $request->email;
            $query->nik = $request->nik;
            $query->email_verified_at = now();
            if ($request->password) {
                $query->password = bcrypt($request->password);
            }
            $query->save();
            $query->syncRoles($request->role);
            $query->assignRole($request->role);
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengubah data',
            ], 200);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mendapatkan data karena terjadi kesalahan!',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $query = User::find(Main::hashIdsDecode($id));
            $query->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data',
            ], 200);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan data karena terjadi kesalahan!',
                'error' => $err->getMessage()
            ], 500);
        }
    }
}
