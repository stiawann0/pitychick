<?php

namespace App\Repositories;

use App\Models\Reservation;
use App\Models\Table;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservationRepository
{
    public function createReservation(array $data)
    {
        try {
            DB::beginTransaction();

            $table = Table::findOrFail($data['table_id']);
            
            if (!$table->isAvailable()) {
                throw new \Exception('Table not available');
            }

            $reservation = Reservation::create($data);
            $table->update(['status' => Table::STATUS_RESERVED]);

            DB::commit();

            return $reservation;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Reservation creation failed: ' . $e->getMessage());
            throw $e;
        }
    }
}