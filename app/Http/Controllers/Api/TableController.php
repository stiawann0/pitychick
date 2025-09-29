<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Table;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TableController extends Controller
{
    public function index()
{
    // Contoh mengambil semua data table dan return json
    $tables = \App\Models\Table::all();
    return response()->json($tables);
}

    public function available(Request $request)
{
    $date = $request->query('date');
    $time = $request->query('time');

    if (!$date || !$time) {
        // Semua meja yang status available dan tidak reserved
        $availableTables = Table::where('status', Table::STATUS_AVAILABLE)->get();
        return response()->json([
            'message' => 'Available tables fetched successfully',
            'data' => $availableTables
        ]);
    }

    // Ambil ID meja yang sudah ada reservasi aktif pada tanggal & waktu tersebut
    $reservedTableIds = \DB::table('reservations')
        ->where('reservation_date', $date)
        ->where('reservation_time', $time)
        ->whereIn('status', [Reservation::STATUS_PENDING, Reservation::STATUS_CONFIRMED])
        ->pluck('table_id')
        ->toArray();

    // Meja yang statusnya available dan tidak termasuk yang reserved pada waktu itu
    $availableTables = Table::where('status', Table::STATUS_AVAILABLE)
        ->whereNotIn('id', $reservedTableIds)
        ->get();

    return response()->json([
        'message' => 'Available tables fetched successfully',
        'data' => $availableTables
    ]);
}
}