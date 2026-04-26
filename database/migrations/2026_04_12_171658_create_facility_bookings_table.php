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
        Schema::create('facility_bookings', function (Blueprint $table) {
        $table->id();
        $table->foreignId('guest_id')->constrained('guests')->onDelete('cascade');
        $table->foreignId('facility_id')->constrained('facilities')->onDelete('cascade');
        $table->foreignId('reservation_id')->nullable()->constrained('reservations')->onDelete('set null');
        $table->datetime('booking_start');
        $table->datetime('booking_end');
        $table->string('status')->default('Pending');
        $table->decimal('total_cost', 10, 2)->default(0);
        $table->integer('rating')->nullable();
        $table->string('last_update_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facility_bookings');
    }
};
