<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('about_settings', function (Blueprint $table) {
        $table->id();
        $table->string('title');
        $table->text('description_1');
        $table->text('description_2')->nullable();
        $table->string('main_image')->nullable(); // uss.jpeg
        $table->string('story_image')->nullable(); // storyus.webp
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('about_settings');
    }
};
