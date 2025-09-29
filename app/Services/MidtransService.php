<?php

namespace App\Services;

use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Reservation;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    /**
     * Buat transaksi Midtrans
     *
     * @param Reservation $reservation
     * @return string snap token
     */
    public function createTransaction(Reservation $reservation)
    {
        // Pastikan data customer tersedia
        $customerName = $reservation->customer_name ?? 'Guest';
        $customerEmail = $reservation->customer_email ?? 'guest@example.com';
        $customerPhone = $reservation->customer_phone ?? '0000000000';

        $params = [
            'transaction_details' => [
                'order_id' => 'RES-' . $reservation->id . '-' . time(),
                'gross_amount' => $reservation->total_price
            ],
            'customer_details' => [
                'first_name' => $customerName,
                'email' => $customerEmail,
                'phone' => $customerPhone
            ],
        ];

        $snap = Snap::createTransaction($params);

        return $snap->token;
    }
}
