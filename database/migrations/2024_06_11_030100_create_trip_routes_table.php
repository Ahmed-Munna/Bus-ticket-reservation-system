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
        Schema::create('trip_routes', function (Blueprint $table) {
            $table->id();
            $table->string('route_name');
            $table->string('starting_point');
            $table->string('destination_point');
            $table->string('distance');
            $table->string('duration');
            $table->boolean('status')->default(1);
            $table->timestamps();

            $table->index(['id','starting_point', 'destination_point']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_routes');
    }
};
