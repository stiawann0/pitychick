<?php

namespace App\Services;

use App\Models\Reservation;
use Twilio\Rest\Client;

class NotificationService
{
    public static function sendConfirmation(Reservation $reservation)
    {
        if (app()->environment('production')) {
            $client = new Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );

            $client->messages->create(
                "+62{$reservation->phone}",
                [
                    'from' => config('services.twilio.from'),
                    'body' => "Reservasi di {$reservation->table->number} " .
                               "untuk {$reservation->reservation_time->format('d/m H:i')} " .
                               "telah dikonfirmasi."
                ]
            );
        }
    }
}