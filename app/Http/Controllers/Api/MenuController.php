<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $menu = Menu::where('deleted_at', '=', null)->get();

            foreach ($menu as $key) {
                unset($key['created_at']);
                unset($key['updated_at']);
                unset($key['deleted_at']);
            }

            return response()->json([
                'status'    => true,
                'code'      => '200',
                'data'      => $menu
            ], 200);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name'      => 'required|max:255|string',
                'price'     => 'required|max:255|string'
            ]);

            $created_menu = Menu::create([
                'name'      => $request->name,
                'price'     => $request->price
            ]);

            if (!$created_menu) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Terjadi kesalahan pada sistem.'
                ], 500);
            }

            unset($created_menu->created_at);
            unset($created_menu->updated_at);
            unset($created_menu->deleted_at);

            return response()->json([
                'status'    => true,
                'code'      => 200,
                'data'      => $created_menu
            ], 200);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $menu = Menu::find($id);
            unset($menu->created_at);
            unset($menu->updated_at);
            unset($menu->deleted_at);

            if (!$menu) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Data tidak ditemukan.'
                ], 404);
            }

            return response()->json([
                'status'    => true,
                'code'      => 200,
                'data'      => $menu
            ], 200);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $finded_menu = Menu::find($id);

            if (!$finded_menu) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Data tidak ditemukan.'
                ], 404);
            }

            $request->validate([
                'name'      => 'max:255|string',
                'price'     => 'max:255|string'
            ]);

            $finded_menu->update([
                'name'      => $request->name ? $request->name : $finded_menu->name,
                'price'     => $request->price ? $request->price : $finded_menu->price
            ]);

            unset($finded_menu->created_at);
            unset($finded_menu->updated_at);
            unset($finded_menu->deleted_at);

            return response()->json([
                'status'    => true,
                'code'      => 200,
                'data'      => $finded_menu
            ], 200);
        } catch (\Throwable $th) {
            return $th;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $finded_menu = Menu::find($id);

            if (!$finded_menu) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Data tidak ditemukan.'
                ], 404);
            }

            $finded_menu->delete();

            return response()->json([
                'status'    => true,
                'code'      => 200,
                'data'      => 0
            ], 200);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
