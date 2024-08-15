<?php

namespace App\Http\Controllers;

use App\Helpers\Main;
use App\Http\Requests\MenuRequest;
use App\Models\Menu;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:Show Manajemen Menu', ['only' => ['index']]);
        $this->middleware('permission:Edit Menu', ['only' => ['edit']]);
        $this->middleware('permission:Delete Menu', ['only' => ['destroy']]);
        $this->middleware('permission:Store Menu', ['only' => ['store']]);
        $this->middleware('permission:Update Menu', ['only' => ['update']]);
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Menu::latest()->whereNull('parent_id')->with('children.children')->orderBy('order_number', 'ASC')->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($row) {
                    return $row->name;
                })
                ->addColumn('url', function ($row) {
                    return $row->url;
                })
                ->addColumn('type', function ($row) {
                    return $row->type;
                })
                ->addColumn('children', function ($row) {
                    $appendChild = '<ol>';
                    foreach ($row->children as $child) {
                        $appendChild .= '<li class="my-2">';
                        $appendChild .= "<a class='text-primary' href='javascript:void(0)' onclick='editItem(`" . Main::hashIdsEncode($child->id) . "`,`" . $child->name . "`)'>" . $child->name . "</a>";
                        $appendChild .= "<span class='mx-1'></span><button type='button' class='btn btn-xs btn-secondary' style='font-size:7px;' onclick='deleteItem(`" . Main::hashIdsEncode($child->id) . "`,`" . $child->name . "`)'>Hapus</button>";
                        $appendChild .= "<ol>";
                        foreach ($child->children as $children) {
                            $appendChild .= "<li>";
                            $appendChild .= "<a class='text-primary' href='javascript:void(0)' onclick='editItem(`" . Main::hashIdsEncode($children->id) . "`,`" . $children->name . "`)'>" . $children->name . "</a>";
                            $appendChild .= "<span class='mx-2'></span><button class='btn btn-xs btn-secondary' style='font-size:7px;' onclick='deleteItem(`" . Main::hashIdsEncode($children->id) . "`,`" . $children->name . "`)'>Hapus</button>";
                            $appendChild .= "</li>";
                        }
                        $appendChild .= "</ol>";
                        $appendChild .= '</li>';
                    }
                    $appendChild .= '</ol>';
                    return $appendChild;
                })
                ->addColumn('action', function ($row) {
                    $btn = '<div class="d-flex gap-2">';
                    $btn .= "<a href='javascript:void(0)' class='btn btn-warning btn-sm' type='button' id='editMenu' onclick='editItem(`" . Main::hashIdsEncode($row->id) . "`,`" . $row->name . "`)'>Ubah</a>";
                    $btn .= "<a href='javascript:void(0)' class='delete btn btn-danger btn-sm' onclick='deleteItem(`" . Main::hashIdsEncode($row->id) . "`,`" . $row->name . "`)'>Hapus</a>";
                    $btn .= '</div>';
                    return $btn;
                })
                ->rawColumns(['action', 'children'])
                ->make(true);
        }
        return view('pages.settings.menu');
    }

    public function parentMenu(Request $request)
    {
        $query = $request->get('q');

        if ($request->condition == 1) {
            $parents = Menu::where('type', 'parent')->where('name', 'like', "%$query%")->get();
        } else {
            $parents = Menu::where('type', 'child-level-1')->where('name', 'like', "%$query%")->get();
        }
        return $parents;
    }

    public function store(MenuRequest $request)
    {
        try {
            $menu = new Menu();
            $menu->name = $request->name;
            $menu->type = $request->type;
            $menu->icon = $request->icon;
            $menu->url = $request->url;
            $menu->parent_id = $request->parent_id;
            $menu->is_visible = 1;
            $menu->save();

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

    public function destroy(Request $request)
    {
        try {
            $countMenus = Menu::where('parent_id', Main::hashIdsDecode($request->id))->count();
            if ($countMenus > 0) {
                $menu = Menu::where('id', Main::hashIdsDecode($request->id));
                $menu->delete();

                $subMenu = Menu::where('parent_id', Main::hashIdsDecode($request->id));
                $subMenu->delete();
            } else {
                $menu = Menu::where('id', Main::hashIdsDecode($request->id));
                $menu->delete();
            }
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menghapus data',
                'data' => $countMenus
            ], 200);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus data karena terjadi kesalahan!',
                'error' => $err->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            $menu = Menu::findOrFail(Main::hashIdsDecode($id));
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mendapatkan data',
                'data' => $menu
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
            $menu = Menu::find($request->id);
            $menu->name = $request->name;
            $menu->icon = $request->icon;
            $menu->url = $request->url;
            $menu->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil mengubah data',
            ], 200);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal mengubah data karena terjadi kesalahan!',
                'error' => $err->getMessage()
            ], 500);
        }
    }
}
