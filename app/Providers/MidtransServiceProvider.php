<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Midtrans\Config;

class MidtransServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $config = config('midtrans');

        Config::$serverKey = $config['server_key'];
        Config::$isProduction = $config['is_production'];
        Config::$isSanitized = $config['is_sanitized'];
        Config::$is3ds = $config['is_3ds'];
    }
}
