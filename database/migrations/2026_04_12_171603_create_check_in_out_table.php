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
        Schema::create('check_in_out', function (Blueprint $table) {
        $table->id();
        $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade');
        $table->foreignId('guest_id')->constrained('guests')->onDelete('cascade');
        $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
        $table->datetime('actual_check_in')->nullable();
        $table->datetime('actual_check_out')->nullable();
        $table->string('status')->default('Checked-in');
        $table->decimal('total_amount', 10, 2)->default(0);
        $table->string('payment_method')->nullable();
        $table->string('last_update_by')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('check_in_out');
    }
};
