<?php

namespace App\Http\Controllers;

use App\Helpers\Main;
use App\Http\Requests\RoleRequest;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\Permission\PermissionRegistrar;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Show Manajemen Role', ['only' => ['index']]);
        $this->middleware('permission:Edit Role', ['only' => ['edit']]);
        $this->middleware('permission:Delete Role', ['only' => ['destroy']]);
        $this->middleware('permission:Store Role', ['only' => ['store']]);
        $this->middleware('permission:Update Role', ['only' => ['update']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Role::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('guard_name', function ($row) {
                    return $row->guard_name;
                })
                ->addColumn('desc', function ($row) {
                    return $row->desc;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex gap-2">';
                    $btn .= "<a href='" . route('setting.access-utilities.roles.edit', ['id' => Main::hashIdsEncode($row->id)]) . "' class='btn btn-warning btn-sm' type='button' id='editMenu'>Ubah</a>";;
                    $btn .= "<a href='javascript:void(0)' class='btn btn-danger btn-sm delete-item' data-id='" . Main::hashIdsEncode($row->id) . "' data-name='" . $row->name . "'>Hapus</a>";
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.settings.access-utilities.role.index');
    }
    public function create()
    {
        $permissions = Permission::orderBy('menu_name')
            ->orderBy('name')
            ->get()
            ->groupBy('menu_name');
        return view('pages.settings.access-utilities.role.create', compact(['permissions']));
    }

    public function store(RoleRequest $request)
    {
        try {
            app()[PermissionRegistrar::class]->forgetCachedPermissions();
            $query = new Role();
            $query->name = $request->name;
            $query->guard_name = $request->guard_name;
            $query->desc = $request->desc;
            $query->save();
            $query->syncPermissions($request->permissions);
            $query->givePermissionTo($request->permissions);
            Cache::flush();
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
        $foundRole = Role::findOrFail(Main::hashIdsDecode($id));
        $foundPermission = Role::with('roleHasPermissions')->find(Main::hashIdsDecode($id));
        $foundPermission = $foundPermission->roleHasPermissions->pluck('permission_id')->toArray();
        $permissions = Permission::orderBy('menu_name')
            ->orderBy('name')
            ->get()
            ->groupBy('menu_name');
        return view('pages.settings.access-utilities.role.edit', compact(['foundPermission', 'foundRole', 'permissions']));
    }

    public function update(Request $request)
    {
        try {
            $query = Role::find(Main::hashIdsDecode($request->id));

            if (!$query) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Role tidak ditemukan',
                ], 404);
            }

            // Cek apakah nilai request lainnya ada
            $name = $request->input('name');
            $guardName = $request->input('guard_name');
            $desc = $request->input('desc');
            $permissions = $request->input('permissions'); // Bisa juga menggunakan $request->permissions

            // Mengatur nilai pada model
            $query->name = $name;
            $query->guard_name = $guardName;
            $query->desc = $desc;
            $query->save();
            Cache::flush();
            // Menyinkronkan permissions jika diperlukan
            if ($permissions) {
                $query->syncPermissions($permissions);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menambahkan data',
            ], 201);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menambahkan data karena terjadi kesalahan!',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $query = Role::find(Main::hashIdsDecode($id));
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
