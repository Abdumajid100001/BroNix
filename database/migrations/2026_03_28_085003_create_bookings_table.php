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
    Schema::create('bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained('users');
        $table->foreignId('business_id')->constrained('businesses');
        $table->foreignId('service_id')->constrained('services');
        $table->date('booking_date');
        
        // 👈 ДОБАВЛЯЕМ СТРОКИ ВРЕМЕНИ, КОТОРЫЕ ИЩЕТ ВАША ФОРМА БРОНИРОВАНИЯ
        $table->string('start_time'); // Время начала (например, "18:00")
        $table->string('end_time');   // Время окончания (например, "19:00")
        
        $table->enum('status', ['pending', 'confirmed', 'cancelled'])->default('pending');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};