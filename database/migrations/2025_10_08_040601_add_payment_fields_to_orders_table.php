<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            // Tambah kolom untuk tracking pembayaran
            $table->enum('payment_status', ['pending', 'paid', 'failed', 'expired', 'refunded'])->default('pending')->after('payment');
            $table->string('payment_method')->nullable()->after('payment_status');
            $table->timestamp('paid_at')->nullable()->after('payment_method');
            $table->timestamp('payment_expired_at')->nullable()->after('paid_at');
            $table->text('payment_notes')->nullable()->after('payment_expired_at');
            
            // Update enum status untuk tambah 'confirmed'
            $table->enum('status', ['pending', 'confirmed', 'processed', 'delivered', 'completed', 'cancelled'])->default('pending')->change();
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'payment_status', 
                'payment_method', 
                'paid_at', 
                'payment_expired_at', 
                'payment_notes'
            ]);
            
            // Kembalikan enum status
            $table->enum('status', ['pending', 'processed', 'delivered', 'completed', 'cancelled'])->default('pending')->change();
        });
    }
};