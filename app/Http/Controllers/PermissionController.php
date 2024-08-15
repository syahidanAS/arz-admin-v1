<?php

namespace App\Http\Controllers;

use App\Helpers\Main;
use App\Http\Requests\PermissionRequest;
use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission as ModelsPermission;
use Spatie\Permission\PermissionRegistrar;
use Yajra\DataTables\Facades\DataTables;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Show Manajemen Permissions', ['only' => ['index']]);
        $this->middleware('permission:Edit Permissions', ['only' => ['edit']]);
        $this->middleware('permission:Delete Permissions', ['only' => ['destroy']]);
        $this->middleware('permission:Store Permissions', ['only' => ['store']]);
        $this->middleware('permission:Update Permissions', ['only' => ['update']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Permission::get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('guard_name', function ($row) {
                    return $row->guard_name;
                })
                ->addColumn('menu_name', function ($row) {
                    return $row->menu_name;
                })
                ->addColumn('action_name', function ($row) {
                    return $row->action_name;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex gap-2">';
                    $btn .= "<a href='" . route('setting.access-utilities.permissions.edit', ['id' => Main::hashIdsEncode($row->id)]) . "' class='btn btn-warning btn-sm' type='button' id='editMenu'>Ubah</a>";;
                    $btn .= "<a href='javascript:void(0)' class='btn btn-danger btn-sm delete-item' data-id='" . Main::hashIdsEncode($row->id) . "' data-name='" . $row->name . "'>Hapus</a>";
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.settings.access-utilities.permission.index');
    }

    public function create()
    {
        return view('pages.settings.access-utilities.permission.create');
    }

    public function store(PermissionRequest $request)
    {
        try {
            app()[PermissionRegistrar::class]->forgetCachedPermissions();
            $query = new ModelsPermission();
            $query->name = $request->name;
            $query->guard_name = $request->guard_name;
            $query->menu_name = $request->menu_name;
            $query->action_name = $request->action_name;
            $query->save();
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
        $decodeId = Main::hashIdsDecode($id);
        $permission = Permission::findOrFail($decodeId);
        return view('pages.settings.access-utilities.permission.edit', compact(['permission']));
    }

    public function update(Request $request)
    {
        try {
            $decodeId = Main::hashIdsDecode($request->id);
            $query = Permission::find($decodeId);
            $query->name = $request->name;
            $query->guard_name = $request->guard_name;
            $query->menu_name = $request->menu_name;
            $query->action_name = $request->action_name;
            $query->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengubah data',
                'data' => $request->all()
            ], 201);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengubah data karena terjadi kesalahan!',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $query = Permission::find(Main::hashIdsDecode($id));
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
