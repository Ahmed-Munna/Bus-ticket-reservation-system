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
        Schema::create('ticket_prices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vehicle_type_id');
            $table->unsignedBigInteger('trip_route_id');
            $table->string('price');
            $table->timestamps();

            $table->index(['id', 'price', 'trip_route_id']);

            $table->foreign('vehicle_type_id')
                  ->references('id')
                  ->on('vehicle_types')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
            $table->foreign('trip_route_id')
                  ->references('id')
                  ->on('trip_routes')
                  ->onUpdate('cascade')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ticket_prices');
    }
};
