<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {

            if (!Schema::hasColumn('service_requests', 'guest_id')) {
                $table->foreignId('guest_id')
                      ->after('id')
                      ->constrained('guests')
                      ->onDelete('cascade');
            }

            if (!Schema::hasColumn('service_requests', 'reservation_id')) {
                $table->foreignId('reservation_id')
                      ->after('guest_id')
                      ->constrained('reservations')
                      ->onDelete('cascade');
            }

            if (!Schema::hasColumn('service_requests', 'room_id')) {
                $table->foreignId('room_id')
                      ->after('reservation_id')
                      ->constrained('rooms')
                      ->onDelete('cascade');
            }

            if (!Schema::hasColumn('service_requests', 'service_id')) {
                $table->foreignId('service_id')
                      ->after('room_id')
                      ->constrained('services')
                      ->onDelete('cascade');
            }

            if (!Schema::hasColumn('service_requests', 'employee_id')) {
                $table->foreignId('employee_id')
                      ->nullable()
                      ->after('service_id')
                      ->constrained('employees')
                      ->onDelete('set null');
            }

            if (!Schema::hasColumn('service_requests', 'quantity')) {
                $table->integer('quantity')->default(1)->after('employee_id');
            }

            if (!Schema::hasColumn('service_requests', 'special_instructions')) {
                $table->text('special_instructions')->nullable()->after('quantity');
            }

            if (!Schema::hasColumn('service_requests', 'status')) {
                $table->string('status')->default('Pending')->after('special_instructions');
            }

            if (!Schema::hasColumn('service_requests', 'total_cost')) {
                $table->decimal('total_cost', 10, 2)->default(0)->after('status');
            }

            if (!Schema::hasColumn('service_requests', 'last_update_by')) {
                $table->string('last_update_by')->nullable()->after('total_cost');
            }

        });
    }

    public function down(): void
    {
        Schema::table('service_requests', function (Blueprint $table) {
            $table->dropForeign(['guest_id']);
            $table->dropForeign(['reservation_id']);
            $table->dropForeign(['room_id']);
            $table->dropForeign(['service_id']);
            $table->dropForeign(['employee_id']);
            $table->dropColumn([
                'guest_id', 'reservation_id', 'room_id',
                'service_id', 'employee_id', 'quantity',
                'special_instructions', 'status',
                'total_cost', 'last_update_by',
            ]);
        });
    }
};