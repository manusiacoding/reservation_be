<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $table = Table::where('deleted_at', '=', null)->get();

            foreach ($table as $key) {
                unset($key['created_at']);
                unset($key['updated_at']);
                unset($key['deleted_at']);
            }

            return response()->json([
                'code'      => 200,
                'status'    => true,
                'data'      => $table
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
                'status'    => 'required|boolean'
            ]);

            $created_table = Table::create([
                'name'      => $request->name,
                'status'    => $request->status
            ]);

            if (!$created_table) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Terjadi kesalahan pada sistem.'
                ], 500);
            }

            unset($created_table->created_at);
            unset($created_table->updated_at);
            unset($created_table->deleted_at);

            return response()->json([
                'status'    => true,
                'code'      => 200,
                'data'      => $created_table
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
            $table = Table::find($id);
            unset($table->created_at);
            unset($table->updated_at);
            unset($table->deleted_at);

            if (!$table) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Data tidak ditemukan.'
                ], 404);
            }

            return response()->json([
                'status'    => true,
                'code'      => 200,
                'data'      => $table
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
            $finded_table = Table::find($id);

            if(!$finded_table) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Data tidak ditemukan.'
                ], 404);
            }

            $request->validate([
                'name'      => 'max:255|string',
                'status'    => 'required'
            ]);

            $finded_table->update([
                'name'      => $request->name ? $request->name : $finded_table->name,
                'status'    => $request->status
            ]);

            unset($finded_table->created_at);
            unset($finded_table->updated_at);
            unset($finded_table->deleted_at);

            return response()->json([
                'status'    => true,
                'code'      => 200,
                'data'      => $finded_table
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
            $finded_table = Table::find($id);

            if (!$finded_table) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Data tidak ditemukan.'
                ], 404);
            }

            $finded_table->delete();

            return response()-> json([
                'status'    => true,
                'code'      => 200,
                'data'      => 0
            ]);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
