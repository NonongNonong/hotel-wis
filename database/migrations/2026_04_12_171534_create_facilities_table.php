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
        Schema::create('facilities', function (Blueprint $table) {
        $table->id();
        $table->string('facility_name');
        $table->string('facility_category');
        $table->text('description')->nullable();
        $table->integer('capacity')->nullable();
        $table->string('status')->default('Available');
        $table->boolean('reservable')->default(true);
        $table->boolean('need_payment')->default(false);
        $table->decimal('price', 10, 2)->default(0);
        $table->string('last_update_by')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
