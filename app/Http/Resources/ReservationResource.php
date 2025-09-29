<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReservationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'customer_name' => $this->customer_name,
            'customer_email' => $this->customer_email,
            'customer_phone' => $this->customer_phone,
            'reservation_time' => $this->reservation_time,
            'guest_number' => $this->guest_number,
            'is_walk_in' => (bool) $this->is_walk_in,
            'status' => $this->status,
            'table' => [
                'id' => $this->table->id,
                'number' => $this->table->number,
                'capacity' => $this->table->capacity,
                'status' => $this->table->status,
            ],
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
        ];
    }
}