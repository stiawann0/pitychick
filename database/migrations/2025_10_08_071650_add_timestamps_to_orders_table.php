<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Tambah kolom untuk tracking timeline order
            $table->json('driver_info')->nullable()->after('payment_notes');
            $table->timestamp('confirmed_at')->nullable()->after('driver_info');
            $table->timestamp('processed_at')->nullable()->after('confirmed_at');
            $table->timestamp('delivered_at')->nullable()->after('processed_at');
            $table->timestamp('completed_at')->nullable()->after('delivered_at');
            $table->string('estimated_delivery_time')->nullable()->after('completed_at');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'driver_info',
                'confirmed_at',
                'processed_at', 
                'delivered_at',
                'completed_at',
                'estimated_delivery_time'
            ]);
        });
    }
};