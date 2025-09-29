<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('navbar_settings', function (Blueprint $table) {
    $table->id();
    $table->string('brand_name')->default('PITY Chick');
    $table->string('logo_path')->nullable(); // path ke logo
    $table->json('menu_items')->nullable(); // simpan list link seperti home, about, dishes, dll
    $table->json('dropdown_items')->nullable(); // simpan isi dropdown: original, add, etc
    $table->boolean('show_auth')->default(true); // tombol login/logout
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('navbar_settings');
    }
};
