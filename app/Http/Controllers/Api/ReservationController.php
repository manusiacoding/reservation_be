<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $reservation = Reservation::where('deleted_at', '=', null)->get();

            foreach ($reservation as $key) {
                unset($key['created_at']);
                unset($key['updated_at']);
                unset($key['deleted_at']);
            }

            return response()->json([
                'code'      => 200,
                'status'    => true,
                'data'      => $reservation
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
                'user_id'       => 'required|max:11|integer',
                'table_id'      => 'required|max:11|integer'
            ]);

            $table = Table::find($request->table_id);

            if ($table->status == true) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Meja dengan ID "' . $request->table_id . '" sudah dibooking oleh user lain.'
                ], 500);
            }
            $reservation_code = "";

            $last_record_reservation = Reservation::latest('id')->first();
            
            if (!$last_record_reservation) {
                $reservation_code = "RSV000001";
            } else {
                $substring_number = (int)substr($last_record_reservation->reservation_code, 3) + 1;
                $reservation_code = "RSV" . sprintf("%06d", $substring_number);
            }

            $reservation = Reservation::create([
                'user_id'           => $request->user_id,
                'table_id'          => $request->table_id,
                'reservation_code'  => $reservation_code,
                'reservation_date'  => $request->reservation_date
            ]);

            $table->update([
                'status'    => true
            ]);

            if (!$reservation) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Terjadi kesalahan pada sistem'
                ], 500);
            }

            return response()->json([
                'code'      => 200,
                'status'    => true,
                'data'      => $reservation
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
            $reservation = Reservation::find($id);
            unset($reservation->created_at);
            unset($reservation->updated_at);
            unset($reservation->deleted_at);

            if (!$reservation) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Data tidak ditemukan.'
                ], 404);
            }

            return response()->json([
                'code'      => 200,
                'status'    => true,
                'data'      => $reservation
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
            $reservation = Reservation::find($id);

            if (!$reservation) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Data tidak ditemukan.'
                ], 404);
            }

            $request->validate([
                'user_id'       => 'max:11|integer',
                'table_id'      => 'max:11|integer'
            ]);

            if ($reservation->table_id != $request->table_id) {
                // Update old table status into false.
                Table::find($reservation->table_id)->update([
                    'status'    => false
                ]);

                // Update new table status into true.
                Table::find($request->table_id)->update([
                    'status'    => true
                ]);
            }

            $reservation->update([
                'user_id'           => $request->user_id,
                'table_id'          => $request->table_id,
                'reservation_date'  => $request->reservation_date,
                'updated_at'        => Carbon::now()
            ]);

            return response()->json([
                'code'      => 200,
                'status'    => true,
                'data'      => $reservation
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
            $reservation = Reservation::find($id);

            if (!$reservation) {
                return response()->json([
                    'status'    => false,
                    'message'   => 'Data tidak ditemukan.'
                ], 404);
            }

            $reservation->delete();

            return response()->json([
                'code'      => 200,
                'status'    => true,
                'data'      => 0
            ], 200);
        } catch (\Throwable $th) {
            return $th;
        }
    }
}
