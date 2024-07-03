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
        Schema::create('trips', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('trip_route');
            $table->unsignedBigInteger('schedule');
            $table->unsignedBigInteger('vehicle_type');
            $table->unsignedBigInteger('vehicle_list');
            $table->unsignedBigInteger('driver_list');
            $table->boolean('status')->default(1);
            $table->timestamps();
        
            $table->index(['id', 'status', 'trip_route', 'schedule']);
        
            $table->foreign('trip_route')
                  ->references('id')
                  ->on('trip_routes')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('vehicle_type')
                  ->references('id')
                  ->on('vehicle_types')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('schedule')
                  ->references('id')
                  ->on('schedules')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('driver_list')
                  ->references('id')
                  ->on('users')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('vehicle_list')
                  ->references('id')
                  ->on('vehicles')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trips');
    }
};
