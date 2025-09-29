<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    const STATUS_PENDING = 'pending';
    const STATUS_CONFIRMED = 'confirmed';
    const STATUS_CANCELLED = 'cancelled';
    
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable(); // Akan diubah ke foreign key di migrasi terpisah
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->foreignId('table_id')->constrained()->onDelete('cascade');
            $table->date('reservation_date');
            $table->dateTime('reservation_time');
            $table->integer('guest_number');
            $table->text('notes')->nullable();
            $table->boolean('is_walk_in')->default(false);
            $table->string('status')->default(self::STATUS_PENDING);
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
        $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
    }
};