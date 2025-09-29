<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateReservationRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'customer_name' => 'sometimes|required|string|max:255',
            'customer_email' => 'sometimes|required|email|max:255',
            'customer_phone' => 'sometimes|required|string|max:20',
            'table_id' => 'sometimes|required|exists:tables,id',
            'reservation_date' => 'sometimes|required|date',
            'reservation_time' => 'sometimes|required|date_format:H:i',
            'guest_number' => 'sometimes|required|integer|min:1|max:20',
            'notes' => 'nullable|string|max:500',
            'status' => 'sometimes|required|in:confirmed,pending,cancelled',
            'is_walk_in' => 'sometimes|boolean',
        ];
    }
}