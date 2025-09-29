<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Http\Resources\ReservationResource;
use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservation::with('table');

        if ($request->has('date')) {
            $query->whereDate('reservation_time', $request->input('date'));
        }

        return ReservationResource::collection($query->latest()->get());
    }

    public function store(StoreReservationRequest $request)
    {
        $data = $request->validated();

        $dateTime = Carbon::parse($data['reservation_date'] . ' ' . $data['reservation_time']);
        $data['reservation_time'] = $dateTime;
        $data['reservation_date'] = $dateTime->toDateString();

        $tableAlreadyBooked = Reservation::where('table_id', $data['table_id'])
            ->where('status', Reservation::STATUS_CONFIRMED)
            ->whereDate('reservation_time', $dateTime->toDateString())
            ->whereTime('reservation_time', $dateTime->toTimeString())
            ->exists();

        if ($tableAlreadyBooked) {
            return response()->json([
                'message' => 'Meja ini sudah dipesan pada waktu tersebut.'
            ], 422);
        }

        $data['status'] = Reservation::STATUS_CONFIRMED;
        $data['is_walk_in'] = false;

        $reservation = Reservation::create($data);

        // Update status meja jadi reserved
$table = Table::find($data['table_id']);
if ($table) {
    $table->status = Table::STATUS_RESERVED;
    $table->save();
}

        return new ReservationResource($reservation->load('table'));
    }

    public function show(Reservation $reservation)
    {
        return new ReservationResource($reservation->load('table'));
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $data = $request->validated();

        if (isset($data['reservation_date']) && isset($data['reservation_time'])) {
            $dateTime = Carbon::parse($data['reservation_date'] . ' ' . $data['reservation_time']);
            $data['reservation_time'] = $dateTime;
            $data['reservation_date'] = $dateTime->toDateString();

            // Cek apakah meja akan bentrok dengan reservasi lain (kecuali dirinya sendiri)
            $conflict = Reservation::where('table_id', $data['table_id'] ?? $reservation->table_id)
                ->where('id', '!=', $reservation->id)
                ->where('status', Reservation::STATUS_CONFIRMED)
                ->whereDate('reservation_time', $dateTime->toDateString())
                ->whereTime('reservation_time', $dateTime->toTimeString())
                ->exists();

            if ($conflict) {
                return response()->json([
                    'message' => 'Meja ini sudah dipesan oleh orang lain pada waktu tersebut.'
                ], 422);
            }
        }

        $reservation->update($data);

        return new ReservationResource($reservation->load('table'));
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->json(['message' => 'Reservasi berhasil dihapus']);
    }

    public function walkIn(Request $request)
    {
        $request->validate([
            'table_id' => 'required|exists:tables,id',
            'guest_number' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:255',
        ]);

        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $now = now();

        // Cek bentrok
        $conflict = Reservation::where('table_id', $request->table_id)
            ->where('status', Reservation::STATUS_CONFIRMED)
            ->whereDate('reservation_time', $now->toDateString())
            ->whereTime('reservation_time', $now->toTimeString())
            ->exists();

        if ($conflict) {
            return response()->json([
                'message' => 'Meja ini sedang dipakai sekarang.'
            ], 422);
        }

        $reservation = Reservation::create([
            'user_id' => $user->id,
            'customer_name' => $user->name,
            'customer_email' => $user->email,
            'customer_phone' => $user->phone ?? '-',
            'table_id' => $request->table_id,
            'reservation_time' => $now,
            'reservation_date' => $now->toDateString(),
            'guest_number' => $request->guest_number,
            'notes' => $request->notes,
            'status' => Reservation::STATUS_CONFIRMED,
            'is_walk_in' => true,
        ]);

        return new ReservationResource($reservation->load('table'));
    }

    public function today()
    {
        $today = Carbon::today();
        $reservations = Reservation::with('table')
            ->whereDate('reservation_time', $today)
            ->orderBy('reservation_time')
            ->get();

        return ReservationResource::collection($reservations);
    }
}
